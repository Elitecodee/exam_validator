@extends('layouts.app', ['title' => 'Login'])

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4 p-md-5">
                <h1 class="uni-page-title h3">University Exam Portal Login</h1>
                <p class="uni-subtitle">Sign in as Department Officer or Lecturer.</p>

                <form method="POST" action="{{ route('login.attempt') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control" required>
                    </div>

                    <div class="form-check mb-3">
                        <input id="remember" name="remember" type="checkbox" value="1" class="form-check-input">
                        <label for="remember" class="form-check-label">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-secondary small mt-3 mb-0">No account? <a href="{{ route('register.form') }}">Register as Lecturer</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
