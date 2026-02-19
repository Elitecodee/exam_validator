@extends('layouts.app', ['title' => 'Register'])

@section('content')
<div class="card" style="max-width: 520px; margin: 40px auto;">
    <h2>Lecturer Registration</h2>
    <p class="muted">Create your lecturer account to start drafting exams.</p>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <label for="name">Full Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>

        <button type="submit">Create Account</button>
    </form>

    <p class="muted">Already registered? <a href="{{ route('login.form') }}">Login</a></p>
</div>
@endsection
