@extends('layouts.app', ['title' => 'Blueprint Settings'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="uni-page-title mb-1">Blueprint Settings</h1>
        <p class="uni-subtitle mb-0">Set curriculum distribution rules for compliant exam generation.</p>
    </div>
    <a href="{{ route('admin.blueprints.create') }}" class="btn btn-primary">+ Create Blueprint</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Name</th><th>Total Marks</th><th>Type Split</th><th>Tolerance</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse ($blueprints as $blueprint)
                    <tr>
                        <td>{{ $blueprint->name }}</td>
                        <td>{{ $blueprint->total_marks }}</td>
                        <td>{{ $blueprint->theory_percentage }}% / {{ $blueprint->problem_solving_percentage }}%</td>
                        <td>±{{ $blueprint->tolerance_percentage }}%</td>
                        <td><span class="badge {{ $blueprint->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $blueprint->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="d-flex flex-wrap gap-1">
                            <a href="{{ route('admin.blueprints.edit', $blueprint) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.blueprints.toggle', $blueprint) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="btn btn-sm btn-outline-warning">{{ $blueprint->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                            <form action="{{ route('admin.blueprints.destroy', $blueprint) }}" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-secondary">No blueprints found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
