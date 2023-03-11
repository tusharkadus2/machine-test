@extends('layouts.main')

@section('content')

<h1>Materials</h1>
<a href="{{ route('materials.create') }}" class="btn btn-success mt-3">Add new</a>

@if($message = Session::get('success'))
    <div class="alert alert-success mt-3">
        <p>{{ $message }}</p>
    </div>
@endif

@if($error = Session::get('error'))
    <div class="alert alert-error mt-3">
        <p>{{ $error }}</p>
    </div>
@endif

<table class="table table-striped mt-5">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($materials as $material)
        <tr>
            <td>{{ $material->name }}</td>
            <td>{{ $material->category->name }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('materials.edit', $material->id) }}">Edit</a>

                @if($material->trashed())
                    <form action="{{ route('materials.restore', $material->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Restore</button>
                    </form>
                @else
                    <form action="{{ route('materials.destroy', $material->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection