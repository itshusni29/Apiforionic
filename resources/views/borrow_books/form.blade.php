@extends('layouts.master')

@section('title', 'Borrow Book')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Borrow Book</h5>
                        <form method="POST" action="{{ route('borrow.book') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" class="form-select">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="book_id" class="form-label">Book</label>
                                <select name="book_id" class="form-select">
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">
                                            {{ $book->judul }}
                                            <div class="mb-3">
                                                <label for="cover">Book Cover</label><br>
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Book Cover" width="100">
                                            </div>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Borrow</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




