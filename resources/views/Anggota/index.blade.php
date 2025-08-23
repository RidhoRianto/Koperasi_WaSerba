@extends('adminlte.layouts.app')

@section('title', 'Koperasi WaSerba | Data Anggota')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Daftar Anggota</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- 🔍 Search Bar --}}
                <form method="GET" action="{{ route('anggota.index') }}" class="mb-3 d-flex" style="max-width: 400px;">
                         <input type="text" name="search" class="form-control mr-2" 
                             placeholder="Cari nama anggota..." 
                             value="{{ request('search') }}"
                             style="background-color: #e9f7ef; border: 1px solid #8f9891ff; color: #000;">
                         <button type="submit" class="btn" style="background-color: #28a745; color: white;">
                            Cari
                        </button>
        </form>


            <a href="{{ route('anggota.create') }}" class="btn btn-primary mb-3">+ Tambah Anggota</a>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggotas as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->email }}</td>
                                <td>{{ $a->no_hp }}</td>
                                <td>
                                    <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if ($anggotas->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data anggota.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
