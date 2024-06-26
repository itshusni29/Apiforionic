@extends('layouts.master')

@section('title', 'Book Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="profile-avatar text-center">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid rounded shadow" alt="{{ $book->judul }}">
                                    @else
                                        <p class="text-muted text-center">No cover available</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h2 class="mb-3">{{ $book->judul }}</h2>
                                <p class="text-muted mb-3">By {{ $book->pengarang }}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Publisher:</strong> {{ $book->penerbit }}</p>
                                        <p><strong>Publication Year:</strong> {{ $book->tahun_terbit }}</p>
                                        <p><strong>Category:</strong> {{ $book->kategori }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Stock:</strong> {{ $book->total_stock }}</p>
                                        <p><strong>Stock Available:</strong> {{ $book->stock_available }}</p>
                                        <p><strong>Ratings:</strong> {{ $book->ratings }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><strong>Description:</strong></p>
                                        <p>{{ $book->deskripsi }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($book->artikel)
                                            <p><strong>PDF:</strong> <a href="{{ asset('storage/' . $book->artikel) }}" target="_blank">View PDF</a></p>
                                        @else
                                            <p><strong>PDF:</strong> No PDF available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end row -->
    </div><!-- end container-fluid -->
@endsection
