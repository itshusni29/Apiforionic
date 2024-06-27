@extends('layouts.master')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body text-center">
                    <div class="row justify-content-center">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 48px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-around mt-3 gap-3">
                        <div class="text-center">
                            <h4 class="mb-0">{{ $totalBooksBorrowed }}</h4>
                            <p class="mb-0 text-secondary">Total Dipinjam</p>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">{{ $totalBooksReturned }}</h4>
                            <p class="mb-0 text-secondary">Total Dikembalikan</p>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">{{ $currentBooksBorrowed }}</h4>
                            <p class="mb-0 text-secondary">Belum di Kembalikan</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="mb-0 text-secondary">{{ $user->alamat }}</p>
                    </div>
                    <hr>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">
                            Email
                            <span class="badge bg-primary rounded-pill">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Nomor Telepon
                            <span class="badge bg-primary rounded-pill">{{ $user->nomor_telpon }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Jenis Kelamin
                            <span class="badge bg-primary rounded-pill">{{ $user->jenis_kelamin }}</span>
                        </li>
                    </ul>
                    <div class="text-center my-4">
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary">Ubah Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
