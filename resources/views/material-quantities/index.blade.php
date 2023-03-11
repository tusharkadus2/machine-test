@extends('layouts.main')

@section('content')

<h1>Manage Material Quantities</h1>

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
            <th>Category</th>
            <th>Material Name</th>
            <th>Opening Balance</th>
            <th>Current Balance</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($materialQuantities as $materialQuantity)
        <tr>
            <td>{{ $materialQuantity->category_name }}</td>
            <td>{{ $materialQuantity->material_name }}</td>
            <td>{{ $materialQuantity->opening_balance }}</td>
            <td>{{ $materialQuantity->current_balance }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('materials.edit', $materialQuantity->id) }}">Edit</a>

                @if($materialQuantity->trashed())
                    <form action="{{ route('materials.restore', $materialQuantity->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Restore</button>
                    </form>
                @else
                    <form action="{{ route('materials.destroy', $materialQuantity->id) }}" method="POST" class="d-inline">
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