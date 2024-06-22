@extends('layouts.master')

@section('title', 'Borrow Book')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pinjam Buku</h5>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="GET" action="{{ route('borrow.form') }}">
                            <div class="mb-3">
                                <label for="search" class="form-label">Cari Buku</label>
                                <input class="form-control" type="text" id="search" name="search" placeholder="Type here to search">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Filter Berdasarkan Kategori</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Pilih Katageri</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ request()->get('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>

                        <form method="POST" action="{{ route('borrow.book') }}">
                            @csrf
                            <div class="mb-3 mt-4">
                                <label for="user_id" class="form-label">Pengguna</label>
                                <select name="user_id" class="form-select" id="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="card bg-transparent shadow-none mt-4">
                                <div class="card-body">
                                    <h6 class="mb-0 text-uppercase">Pilih Buku</h6>
                                    <div class="my-3 border-top"></div>
                                    <div class="card-group">
                                        @foreach ($books as $book)
                                            <div class="card border-end">
                                                <img src="{{ asset('storage/' . $book->cover) }}" class="card-img-top" alt="{{ $book->judul }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $book->judul }}</h5>
                                                    <p class="card-text">{{ $book->deskripsi }}</p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="selected_books[]" value="{{ $book->id }}" id="{{ $book->id }}">
                                                        <label class="form-check-label" for="{{ $book->id }}">Select</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Pinjam</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
