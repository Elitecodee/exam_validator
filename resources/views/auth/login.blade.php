@extends('layouts.app', ['title' => 'Login'])

@section('content')
<div class="card" style="max-width: 520px; margin: 40px auto;">
    <h2>Login</h2>
    <p class="muted">Sign in as Admin/Department Officer or Lecturer.</p>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <label>
            <input name="remember" type="checkbox" value="1" style="width: auto;"> Remember me
        </label>

        <button type="submit">Login</button>
    </form>

    <p class="muted">No account? <a href="{{ route('register.form') }}">Register as Lecturer</a></p>
</div>
@endsection
