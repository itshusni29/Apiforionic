@extends('layouts.master')

@section('title', 'User Profile')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-lg-4">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-body">
                        <div class="profile-avatar text-center">
                            <img src="{{ asset('storage/' . $user->photo_profile) }}" class="rounded-circle shadow" width="120" height="120" alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-around mt-5 gap-3">
                            <div class="text-center">
                                <h4 class="mb-0">we</h4>
                                <p class="mb-0 text-secondary">Friends</p>
                            </div>
                            <div class="text-center">
                                <h4 class="mb-0">we</h4>
                                <p class="mb-0 text-secondary">Photos</p>
                            </div>
                            <div class="text-center">
                                <h4 class="mb-0">we/h4>
                                <p class="mb-0 text-secondary">Comments</p>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="mb-0 text-secondary">{{ $user->alamat }}</p>
                            <div class="mt-4"></div>
                        </div>
                        <hr>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">
                            Email
                            <span class="badge bg-primary rounded-pill">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Phone Number
                            <span class="badge bg-primary rounded-pill">{{ $user->nomor_telpon }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Gender
                            <span class="badge bg-primary rounded-pill">{{ $user->jenis_kelamin }}</span>
                        </li>
                    </ul>
                    <div class="text-center my-5">
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
