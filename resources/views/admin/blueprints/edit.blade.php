@extends('layouts.app', ['title' => 'Edit Blueprint'])

@section('content')
<h1>Edit Blueprint</h1>

@if ($errors->any())
    <div class="card" style="border: 1px solid #ef4444;">
        <strong>Please fix the following:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form method="POST" action="{{ route('admin.blueprints.update', $blueprint) }}">
        @csrf
        @method('PUT')
        @include('admin.blueprints._form', ['blueprint' => $blueprint])
        <button type="submit">Update Blueprint</button>
    </form>
</div>
@endsection
