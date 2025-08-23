<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function index()
    {
        $saldo = Saldo::first();
        return view('saldo.index', compact('saldo'));
    }

    public function edit()
    {
        $saldo = Saldo::first();
        return view('saldo.edit', compact('saldo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0'
        ]);

        $saldo = Saldo::first();
        $saldo->jumlah = $request->jumlah;
        $saldo->save();

        return redirect()->route('saldo.index')->with('success', 'Saldo berhasil diperbarui');
    }
}

