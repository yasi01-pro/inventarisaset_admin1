@extends('layouts.main')

@section('title','Login')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center fw-bold">
                Login
            </div>

            <div class="card-body">

                {{-- Notif SUCCESS --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Notif ERROR General (email/pass salah dari controller) --}}
                @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="alert alert-danger">
                        Email atau password tidak valid.
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="Masukkan email...">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Masukkan password...">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- BUTTON LOGIN --}}
                    <button class="btn btn-primary w-100 fw-bold">
                        Login
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
