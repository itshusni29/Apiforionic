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
                                <select name="book_id" class="form-select" id="bookSelect">
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}" data-cover="{{ asset('storage/' . $book->cover) }}">{{ $book->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cover">Book Cover</label><br>
                                <img id="coverImage" src="" alt="Book Cover" width="100" style="display:none;">
                            </div>
                            <button type="submit" class="btn btn-primary">Borrow</button>
                        </form>



                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('bookSelect').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var coverImage = document.getElementById('coverImage');
            var coverUrl = selectedOption.getAttribute('data-cover');

            if (coverUrl) {
                coverImage.src = coverUrl;
                coverImage.style.display = 'block';
            } else {
                coverImage.style.display = 'none';
            }
        });

        // Trigger the change event to display the image of the first book by default
        document.getElementById('bookSelect').dispatchEvent(new Event('change'));
    </script>
@endsection
