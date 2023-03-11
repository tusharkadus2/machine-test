@extends('layouts.main')

@section('content')

<h1>Categories</h1>
<a href="{{ route('categories.create') }}" class="btn btn-success mt-3">Add new</a>

@if($message = Session::get('success'))
    <div class="alert alert-success mt-3">
        <p>{{ $message }}</p>
    </div>
@endif

@if($error = Session::get('error'))
    <div class="alert alert-danger mt-3">
        <p>{{ $error }}</p>
    </div>
@endif

<table class="table table-striped mt-5">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">Edit</a>

                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection