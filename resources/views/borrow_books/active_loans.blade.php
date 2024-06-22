@extends('layouts.master')

@section('title', 'Customers with Borrowed Books')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Peminjam Dan Buku Yang Dipinjam</h5>
                            <a href="{{ route('borrow.form') }}" class="btn btn-primary ms-auto">Pinjam Buku</a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Profil Poto</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($usersWithLoans->isNotEmpty())
                                        @foreach($usersWithLoans as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->photo_profile)
                                                        <img src="{{ asset('storage/' . $user->photo_profile) }}" class="rounded-circle" width="44" height="44" alt="">
                                                    @else
                                                        No Photo
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('borrowed.books.user', $user->id) }}" class="btn btn-primary">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No customers with borrowed books found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
