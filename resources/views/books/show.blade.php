@extends('layouts.master')

@section('title', 'Book Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-lg-4">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-body">
                        <div class="profile-avatar text-center">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" class="rounded-circle shadow" width="120" height="120" alt="{{ $book->judul }}">
                            @else
                                <p>No cover available</p>
                            @endif
                        </div>
                        <div class="text-center mt-4">
                            <h4 class="mb-1">{{ $book->judul }}</h4>
                            <p class="mb-0 text-secondary">{{ $book->pengarang }}</p>
                            <div class="mt-4"></div>
                        </div>
                        <hr>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">
                            Publisher
                            <span class="badge bg-primary rounded-pill">{{ $book->penerbit }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Publication Year
                            <span class="badge bg-primary rounded-pill">{{ $book->tahun_terbit }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Category
                            <span class="badge bg-primary rounded-pill">{{ $book->kategori }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Total Stock
                            <span class="badge bg-primary rounded-pill">{{ $book->total_stock }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Description
                            <span class="badge bg-primary rounded-pill">{{ $book->deskripsi }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            Ratings
                            <span class="badge bg-primary rounded-pill">{{ $book->ratings }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!--end row-->
    </div>
@endsection
