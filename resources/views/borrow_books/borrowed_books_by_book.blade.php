@extends('layouts.master')

@section('title', 'Borrowed Books')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List Buku Dipinjam</h5>
                        <div class="table-responsive mt-3">
                            <table class="table align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No</th>
                                        <th>Sampul</th>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrowedBooks as $index => $borrowedBook)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($borrowedBook->book->cover)
                                                    <img src="{{ asset('storage/' . $borrowedBook->book->cover) }}" class="rounded-circle" width="44" height="44" alt="Book Cover">
                                                @else
                                                    No cover available
                                                @endif
                                            </td>
                                            <td>{{ $borrowedBook->book->judul }}</td>
                                            <td>{{ $borrowedBook->book->pengarang }}</td>
                                            <td>{{ $borrowedBook->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($borrowedBook->tanggal_peminjaman)->format('d M Y') }}</td>
                                            <td>{{ $borrowedBook->status }}</td>
                                            <td>
                                                @if($borrowedBook->status === 'Dipinjam')
                                                    <form action="{{ route('return.book', $borrowedBook->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary">Return</button>
                                                    </form>
                                                @else
                                                    N/A
                                                @endif
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
