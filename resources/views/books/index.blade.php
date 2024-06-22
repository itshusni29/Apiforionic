@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Daftar Buku</h5>
                            <form class="ms-auto position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                                <input class="form-control ps-5" type="text" placeholder="search">
                            </form>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Terbit</th>
                                        <th>Kategori</th>
                                        <th>Total Tersedia</th>
                                        <th>Deskripsi</th>
                                        <th>Penilaian</th>
                                        <th>Sampul</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                        <tr>
                                            <td>{{ $book->id }}</td>
                                            <td>{{ $book->judul }}</td>
                                            <td>{{ $book->pengarang }}</td>
                                            <td>{{ $book->penerbit }}</td>
                                            <td>{{ $book->tahun_terbit }}</td>
                                            <td>{{ $book->kategori }}</td>
                                            <td>{{ $book->total_stock }}</td>
                                            <td>{{ $book->deskripsi }}</td>
                                            <td>{{ $book->ratings }}</td>
                                            <td>
                                                @if($book->cover)   
                                                    <img src="{{ asset('storage/' . $book->cover) }}" class="rounded-circle" width="44" height="44" alt="">
                                                @else
                                                    No cover available
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                    <a href="{{ route('books.show', $book->id) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="bi bi-eye-fill"></i></a>
                                                    <a href="{{ route('books.edit', $book->id) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
