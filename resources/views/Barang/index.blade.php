@extends('adminlte.layouts.app')

@section('title', 'WaSerba | Manajemen Barang')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Barang</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('barang.create') }}" class="btn btn-primary">+ Tambah Barang</a>

                        <form method="GET" action="{{ route('barang.index') }}">
                            <label>
                              
                            </label>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr class="{{ $item->stok == 0 ? 'table-danger' : '' }}">
                                            <td>
                                                {{ $item->nama }}
                                                @if($item->stok == 0)
                                                    <span class="badge bg-danger ml-2">Out of Stocks</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->kategori }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
@endsection
