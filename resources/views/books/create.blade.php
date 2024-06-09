@extends('layouts.master')

@section('title', 'Create New Book')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">Create New Book</h6>
                            <hr/>
                            <form method="POST" action="{{ route('books.store') }}" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-6">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="judul" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tahun Terbit</label>
                                    <input type="date" name="tahun_terbit" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" name="kategori" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Total Stock</label>
                                    <input type="number" name="total_stock" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Ratings</label>
                                    <input type="number" name="ratings" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Cover</label>
                                    <input type="file" name="cover" class="form-control">
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
