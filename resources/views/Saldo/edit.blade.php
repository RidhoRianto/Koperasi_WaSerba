@extends('adminlte.layouts.app')

@section('title', 'Edit Saldo')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Saldo</h1>
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
                            <form method="POST" action="{{ route('saldo.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="jumlah">Jumlah Saldo (Rp)</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $saldo->jumlah }}" step="any" required>
                                </div>


                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('saldo.index') }}" class="btn btn-danger">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
