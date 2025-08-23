@extends('adminlte.layouts.auth')

@section('title', 'Login')

@section('content')
<body class="hold-transition login-page" style="margin:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div style="display: flex; height: 100vh;">

      {{-- Kiri: Gambar & Branding --}}
<div style="flex: 1; position: relative; background-image: url('{{ asset('assetsLanding/img/koperasi_waserba2.jpg') }}'); background-size: cover; background-position: center;">

    {{-- Overlay transparan --}}
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5);"></div>

    {{-- Teks di atas gambar --}}
    <div style="position: relative; z-index: 1; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; padding: 40px; text-align: center;">
        <h1 style="font-family: monospace; font-size: 2rem; font-weight: bold;">Koperasi WaSerba</h1>
        <h2 style="font-family: monospace; font-size: 1.5rem;">Karyawan</h2>
    </div>

</div>

        {{-- Kanan: Form Login --}}
        <div style="flex: 1; background-color: white; display: flex; justify-content: center; align-items: center;">
            <div style="width: 100%; max-width: 400px;">
                <h3 style="font-weight: normal; margin-bottom: 30px;">      
                </h3>

                @if (Session::has('reset_success'))
                    <div class="alert alert-success">
                        {{ Session::get('reset_success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    {{-- Email --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                        <span class="input-group-text" style="cursor:pointer;">
                            <i class="fas fa-eye" id="togglePassword"></i>
                        </span>
                        @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tombol Login --}}
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100" style="border-radius: 6px;">Log in</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Toggle Password --}}
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
@endsection
