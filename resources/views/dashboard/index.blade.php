@extends('layouts.main')

@section('content')

<h1 class="text-center">Dashboard</h1>

<div class="row mt-5 text-center">
    <div class="col-md-4 p-3">
        <div class="card">
            <h5 class="card-header">Categories</h5>
            <div class="card-body">
                <p class="card-text">Add/edit/delete categories</p>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">View All</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 p-3">
        <div class="card">
            <h5 class="card-header">Materials</h5>
            <div class="card-body">
                <p class="card-text">Add/edit/delete materials</p>
                <a href="{{ route('materials.index') }}" class="btn btn-primary">View All</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 p-3">
        <div class="card">
            <h5 class="card-header">Material Quantities</h5>
            <div class="card-body">
                <p class="card-text">Add materials</p>
                <a href="{{ route('quantities.create') }}" class="btn btn-primary">Add</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 p-3">
        <div class="card">
            <h5 class="card-header">Manage Materials</h5>
            <div class="card-body">
                <p class="card-text">View Opening/Current balance of materials</p>
                <a href="{{ route('material.quantities.index') }}" class="btn btn-primary">View All</a>
            </div>
        </div>
    </div>
</div>



@endsection