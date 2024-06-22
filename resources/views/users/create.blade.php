@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">Formulir Pendaftaran</h6>
                            <hr/>
                            <form method="POST" action="{{ route('users.store') }}" class="row g-3">
                                @csrf
                                <div class="col-6">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nomor Telpon</label>
                                    <input type="text" name="nomor_telpon" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Peran</label>
                                    <input type="text" name="roles" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <input type="text" name="jenis_kelamin" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Profil Poto</label>
                                    <input type="file" name="photo_profile" class="form-control">
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
