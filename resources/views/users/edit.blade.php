@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">Update User</h6>
                            <hr/>
                            <form method="POST" action="{{ route('users.update', $user->id) }}" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email ID</label>
                                    <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" value="{{ $user->alamat }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nomor Telpon</label>
                                    <input type="text" name="nomor_telpon" value="{{ $user->nomor_telpon }}" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Roles</label>
                                    <input type="text" name="roles" value="{{ $user->roles }}" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <input type="text" name="jenis_kelamin" value="{{ $user->jenis_kelamin }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Photo Profile @if(!$user->photo_profile) <span class="text-danger">(required)</span> @endif</label>
                                    <input type="file" name="photo_profile" class="form-control">
                                    @if(!$user->photo_profile)
                                        <small class="text-muted">File should be in JPEG, PNG, JPG, or GIF format and should not exceed 2MB.</small>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
