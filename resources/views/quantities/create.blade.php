@extends('layouts.main')

@section('content')

<h1 class="mt-5">Add Inward/Outward Quantity</h1>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

<form action="{{ route('quantities.store') }}" method="POST" class="mt-4">
    @csrf

    <div class="mb-3 mt-3">
        <label for="category_id">Material Category:</label>
        <select class="form-control @error('category_id') border-danger @enderror" id="category_id" name="category_id" required>
            <option value="">Select material category</option>
            @foreach($categories as $category)
            <option @if(old('category_id') == $category->id) selected @endif
                value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3 mt-3">
        <label for="material_id">Material Name:</label>
        <select class="form-control @error('material_id') border-danger @enderror" id="material_id" name="material_id" required @if(empty($materials)) disabled @endif>
            <option value="">
                @if(empty($materials)) Please select category first @else Select material name @endif
            </option>
            @if(!empty($materials))
                @foreach($materials as $material)
                <option @if(old('material_id') == $material->id) selected @endif
                    value="{{ $material->id }}">{{ $material->name }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="mb-3 mt-3">
        <label for="date">Date:</label>
        <input type="date" id="date" class="form-control @error('date') border-danger @enderror" placeholder="Select date" name="date" value="{{ old('date') }}" required>
    </div>

    <div class="mb-3 mt-3">
        <label for="quantity">Quantity:</label>
        <input type="number" step="0.01" id="quantity" class="form-control @error('quantity') border-danger @enderror" placeholder="Enter quantity" name="quantity" value="{{ old('quantity') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">
    // update material names by category selected
    $('#category_id').on('change', function () {
        var categoryId = this.value,
            $materialNamesDd = $('#material_id');

        $.ajax({
            url: '{{ route("material.by-category.get") }}',
            type: 'GET',
            data: { category_id: categoryId },
            success: function (resp) {
                if (resp.materials) {
                    $materialNamesDd.empty().attr('disabled', false);

                    $materialNamesDd.append('<option value="">Select Material Name</option>');

                    $.each(resp.materials, function (i, k) {
                        $materialNamesDd.append(`<option value="${k.id}">${k.name}</option>`);
                    });
                }
            }
        });
    });
</script>

@endsection