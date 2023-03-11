@extends('layouts.main')

@section('content')

<a href="{{ route('materials.index') }}" class="btn btn-success mt-3">Browse materials listing</a>
<h1 class="mt-5">Edit Material</h1>

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

<form action="{{ route('materials.update', $material->id) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')

    <div class="mb-3 mt-3">
        <label for="name">Name:</label>
        <input type="text" id="name" class="form-control @error('name') border-danger @enderror" placeholder="Enter material name" name="name" value="{{ old('name', $material->name) }}" required autofocus>
    </div>

    <div class="mb-3 mt-3">
        <label for="category">Category:</label>
        <select class="form-control @error('category_id') border-danger @enderror" name="category_id" required>
            <option value="">Select category</option>
            @foreach($categories as $category)
            <option @if(old('category_id', $material->category_id) == $category->id) selected @endif
                value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3 mt-3">
        <label for="opening-balance">Opening Balance:</label>
        <input type="number" step="0.001" id="opening-balance" class="form-control @error('opening_balance') border-danger @enderror" placeholder="Enter opening balance" name="opening_balance" value="{{ old('opening_balance', $material->opening_balance) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection