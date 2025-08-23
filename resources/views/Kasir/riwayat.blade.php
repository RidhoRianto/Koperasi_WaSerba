@extends('adminlte.layouts.app')

@section('title', 'WaSerba | Riwayat Transaksi')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Riwayat Transaksi</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Detail Barang</th>
                                <th>Diskon</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <ul>
                                        @foreach($transaksi->details as $detail)
                                            <li>{{ $detail->item->nama }} ({{ $detail->jumlah }}): Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
