@extends('layouts.master')

@section('title', 'Create New Book')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Tambah Buku Baru</h6>
                        <hr/>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('books.store') }}" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="col-6">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Pengarang</label>
                                <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="date" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-control select2" style="width: 100%;">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('kategori') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6">
                                <label class="form-label">Total Stok</label>
                                <input type="number" name="total_stock" class="form-control" value="{{ old('total_stock') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penilaian</label>
                                <input type="number" name="ratings" class="form-control" value="{{ old('ratings') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Sampul</label>
                                <input type="file" name="cover" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Artikel (PDF)</label>
                                <input type="file" name="artikel" class="form-control">
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tambahkan</button>
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
