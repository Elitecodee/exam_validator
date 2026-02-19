@extends('layouts.app', ['title' => 'Blueprint Settings'])

@section('content')
<h1>Blueprint Settings</h1>
<p class="muted">Create and manage exam blueprint rules for validation.</p>

<div class="card">
    <a href="{{ route('admin.blueprints.create') }}">+ Create Blueprint</a>
</div>

<div class="card">
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding: 8px;">Name</th>
                <th style="text-align:left; padding: 8px;">Total Marks</th>
                <th style="text-align:left; padding: 8px;">Type Split</th>
                <th style="text-align:left; padding: 8px;">Tolerance</th>
                <th style="text-align:left; padding: 8px;">Status</th>
                <th style="text-align:left; padding: 8px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($blueprints as $blueprint)
            <tr>
                <td style="padding: 8px;">{{ $blueprint->name }}</td>
                <td style="padding: 8px;">{{ $blueprint->total_marks }}</td>
                <td style="padding: 8px;">{{ $blueprint->theory_percentage }}% / {{ $blueprint->problem_solving_percentage }}%</td>
                <td style="padding: 8px;">±{{ $blueprint->tolerance_percentage }}%</td>
                <td style="padding: 8px;">{{ $blueprint->is_active ? 'Active' : 'Inactive' }}</td>
                <td style="padding: 8px;">
                    <a href="{{ route('admin.blueprints.edit', $blueprint) }}">Edit</a>
                    |
                    <form action="{{ route('admin.blueprints.toggle', $blueprint) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="padding:4px 8px;">{{ $blueprint->is_active ? 'Deactivate' : 'Activate' }}</button>
                    </form>
                    |
                    <form action="{{ route('admin.blueprints.destroy', $blueprint) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding:4px 8px; background:#dc2626;">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="padding:8px;" class="muted">No blueprints found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
