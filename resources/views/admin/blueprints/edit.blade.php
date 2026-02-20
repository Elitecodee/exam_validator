@extends('layouts.app', ['title' => 'Edit Blueprint'])

@section('content')
<h1 class="uni-page-title">Edit Blueprint</h1>
<p class="uni-subtitle">Refine distribution rules and tolerance boundaries.</p>

@if ($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.blueprints.update', $blueprint) }}">
        @csrf
        @method('PUT')
        @include('admin.blueprints._form', ['blueprint' => $blueprint])
        <button type="submit" class="btn btn-primary mt-3">Update Blueprint</button>
    </form>
</div></div>
@endsection
