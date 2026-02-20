@extends('layouts.app', ['title' => 'Create Blueprint'])

@section('content')
<h1 class="uni-page-title">Create Blueprint</h1>
<p class="uni-subtitle">Define academic structure, difficulty targets, and tolerance ranges.</p>

@if ($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.blueprints.store') }}">
        @csrf
        @include('admin.blueprints._form')
        <button type="submit" class="btn btn-primary mt-3">Save Blueprint</button>
    </form>
</div></div>
@endsection
