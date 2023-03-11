@extends('layouts.main')

@section('content')

<a href="{{ route('categories.index') }}" class="btn btn-success mt-3">Browse categories listing</a>
<h1 class="mt-5">Add Category</h1>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($error = Session::get('error'))
    <div class="alert alert-danger mt-3">
        <p>{{ $error }}</p>
    </div>
@endif

<form action="{{ route('categories.store') }}" method="POST" class="mt-3">
    @csrf

    <div class="mb-3 mt-3">
        <label for="name">Name:</label>
        <input type="text" id="name" class="form-control @error('name') border-danger @enderror" placeholder="Enter category name" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection