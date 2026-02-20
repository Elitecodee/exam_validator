@extends('layouts.app', ['title' => 'Create Blueprint'])

@section('content')
<h1>Create Blueprint</h1>

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
    <form method="POST" action="{{ route('admin.blueprints.store') }}">
        @csrf
        @include('admin.blueprints._form')
        <button type="submit">Save Blueprint</button>
    </form>
</div>
@endsection
