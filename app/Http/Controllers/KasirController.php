<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Saldo;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $items = $search ? Item::where('nama', 'like', "%$search%")->get() : Item::all();
        return view('Kasir.index', compact('items'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.jumlah'  => 'required|integer|min:0'
        ]);

        $isAnggota = $request->has('is_anggota');
        $selectedItems = [];
        $subtotal = 0;

        foreach ($request->items as $itemData) {
            if ($itemData['jumlah'] > 0) {
                $item = Item::find($itemData['item_id']);
                if (!$item) continue;

                $totalHarga = $item->harga * $itemData['jumlah'];
                $selectedItems[] = [
                    'id'     => $item->id,
                    'nama'   => $item->nama,
                    'harga'  => $item->harga,
                    'jumlah' => $itemData['jumlah'],
                    'total'  => $totalHarga
                ];

                $subtotal += $totalHarga;
            }
        }

        $diskon = $isAnggota ? $subtotal * 0.1 : 0;
        $totalBayar = $subtotal - $diskon;

        return view('Kasir.preview', compact('selectedItems', 'isAnggota', 'subtotal', 'diskon', 'totalBayar'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'items'       => 'required|array',
            'total_bayar' => 'required|numeric'
        ]);

        $isAnggota = $request->has('is_anggota');
        $subtotal = 0;

        foreach ($request->input('items') as $itemData) {
            $item = Item::find($itemData['item_id']);
            if ($item && $itemData['jumlah'] > 0) {
                $subtotal += $item->harga * $itemData['jumlah'];
            }
        }

        $diskon = $isAnggota ? $subtotal * 0.1 : 0;
        $totalBayar = $subtotal - $diskon;

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'is_anggota' => $isAnggota,
            'diskon'     => $diskon,
            'total'      => $totalBayar
        ]);

        // Simpan detail & kurangi stok
        foreach ($request->input('items') as $itemData) {
            if ($itemData['jumlah'] > 0) {
                $item = Item::find($itemData['item_id']);
                if (!$item) continue;

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'item_id'      => $item->id,
                    'jumlah'       => $itemData['jumlah'],
                    'harga_satuan' => $item->harga
                ]);

                $item->stok -= $itemData['jumlah'];
                $item->save();
            }
        }

        // Update saldo koperasi
        $saldo = Saldo::first();
        if (!$saldo) {
            $saldo = Saldo::create(['jumlah' => $totalBayar]);
        } else {
            $saldo->jumlah += $totalBayar;
            $saldo->save();
        }

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan dan saldo koperasi diperbarui!');
    }

    public function riwayat()
    {
        $transaksis = Transaksi::with('details.item')->latest()->limit(10)->get();
        return view('Kasir.riwayat', compact('transaksis'));
    }
}
