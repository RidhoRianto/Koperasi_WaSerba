@extends('adminlte.layouts.app')

@section('title', 'Preview Struk')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <h1>Preview Struk</h1>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <p>Status Anggota: {{ $isAnggota ? 'Ya (Diskon 10%)' : 'Tidak' }}</p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedItems as $item)
                            <tr>
                                <td>{{ $item['nama'] }}</td>
                                <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h5>Subtotal: Rp {{ number_format($subtotal,0,',','.') }}</h5>
                    <h5>Diskon: Rp {{ number_format($diskon,0,',','.') }}</h5>
                    <h4>Total: Rp {{ number_format($totalBayar,0,',','.') }}</h4>


                    <form action="{{ route('kasir.simpan') }}" method="POST">
                    @csrf

                        <input type="hidden" name="is_anggota" value="{{ $isAnggota ? 1 : 0 }}">
                        <input type="hidden" name="total_bayar" value="{{ $totalBayar }}">

                    @foreach($selectedItems as $index => $item)
                        <input type="hidden" name="items[{{ $index }}][item_id]" value="{{ $item['id'] }}">
                            <input type="hidden" name="items[{{ $index }}][jumlah]" value="{{ $item['jumlah'] }}">
                    @endforeach

                        <div class="mt-3">
                                <button type="submit" class="btn btn-success">Konfirmasi & Simpan</button>
                                <a href="{{ route('kasir.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
