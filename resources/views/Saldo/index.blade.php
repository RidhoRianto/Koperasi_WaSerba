@extends('adminlte.layouts.app')

@section('title', 'Saldo Koperasi')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Saldo Koperasi</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card bg-success">
                        <div class="card-body">
                            <i class="fas fa-coins icon-top-right"></i>
                            <h5 class="card-title text-light">Saldo Koperasi</h5>
                            <h5 class="card-text font-weight-bold text-white">
                                Rp {{ number_format($saldo->jumlah, 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Edit -->
            <div class="row mt-2">
                <div class="col-md-12">
                    <a href="{{ route('saldo.edit') }}" class="btn btn-primary">Edit Saldo</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
