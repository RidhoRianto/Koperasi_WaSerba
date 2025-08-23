@extends('adminlte.layouts.app')

@section('title', 'WaSerba | Transaksi Kasir')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Transaksi Kasir</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            {{-- 🔍 Search Barang (Auto Scroll) --}}
            <div class="mb-3 d-flex" style="max-width: 400px;">
                <input type="text" id="searchInput" class="form-control mr-2" placeholder="Cari nama barang...">
                <button type="button" id="searchBtn" class="btn btn-success">Cari</button>
            </div>

            <form method="POST" action="{{ route('kasir.preview') }}">
                @csrf

                <div class="mb-3">
                    <label>
                        <input type="checkbox" name="is_anggota" value="1"> Anggota (Diskon 10%)
                    </label>
                </div>

                <div class="card">
                    {{-- ✅ Tombol Konfirmasi & Riwayat di Atas --}}
                    <div class="card-header d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-2">Konfirmasi Bayar</button>
                        <a href="{{ route('kasir.riwayat') }}" class="btn btn-info">Riwayat Transaksi</a>
                    </div>

                    <div class="card-body table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-bordered table-hover" id="tableBarang">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Jumlah Beli</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $i => $item)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td class="nama-barang">{{ $item->nama }}</td>
                                    <td>{{ $item->kategori }}</td>
                                    <td>
                                        @if($item->stok > 0) {{ $item->stok }}
                                        @else <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->stok > 0)
                                            <input type="hidden" name="items[{{ $i }}][item_id]" value="{{ $item->id }}">
                                            <input type="number" name="items[{{ $i }}][jumlah]" class="form-control" min="0" max="{{ $item->stok }}" value="0">
                                        @else -
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Barang tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>


<script>
    document.getElementById('searchBtn').addEventListener('click', function() {
            let keyword = document.getElementById('searchInput').value.toLowerCase().trim();
            let rows = document.querySelectorAll('#tableBarang tbody tr');
            let found = false;

        rows.forEach(row => {
            let nama = row.querySelector('.nama-barang').textContent.toLowerCase();
                if (nama.includes(keyword) && keyword !== '') {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.style.backgroundColor = '#d4edda'; // highlight hijau
                setTimeout(() => row.style.backgroundColor = '', 2000);
                found = true;
        }
    });

        if (!found && keyword !== '') {
            alert('Barang tidak ditemukan!');
    }
    });
</script>
@endsection
