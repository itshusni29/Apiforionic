@extends('layouts.master')

@section('title', 'Update Book')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Update Book</h6>
                        <hr/>
                        <form method="POST" action="{{ route('books.update', $book->id) }}" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-6">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" value="{{ $book->judul }}" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Pengarang</label>
                                <input type="text" name="pengarang" value="{{ $book->pengarang }}" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ $book->penerbit }}" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="date" name="tahun_terbit" value="{{ $book->tahun_terbit }}" class="form-control">
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
                                <input type="number" name="total_stock" value="{{ $book->total_stock }}" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control">{{ $book->deskripsi }}</textarea>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Penilaian</label>
                                <input type="number" name="ratings" value="{{ $book->ratings }}" class="form-control">
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
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
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
