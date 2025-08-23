@extends('adminlte.layouts.app')

@section('title', 'WaSerba | Profil Saya')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil Saya</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ Auth::user()->tempat_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ Auth::user()->tanggal_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>{{ Auth::user()->jenis_kelamin ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{ Auth::user()->agama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ Auth::user()->alamat ?? '-' }}</td>
                                    </tr>
                                </table>

                                <div class="mt-3">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
