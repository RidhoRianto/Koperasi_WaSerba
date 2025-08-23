@extends('adminlte.layouts.app')

@section('title', 'Koperasi WaSerba | Edit Anggota')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Edit Anggota</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" name="nama" value="{{ old('nama', $anggota->nama) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $anggota->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP:</label>
                            <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}">
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('anggota.index') }}" class="btn btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
