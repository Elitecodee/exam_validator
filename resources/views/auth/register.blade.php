@extends('layouts.app', ['title' => 'Register'])

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4 p-md-5">
                <h1 class="uni-page-title h3">Lecturer Registration</h1>
                <p class="uni-subtitle">Create an academic staff account to draft exams.</p>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Create Account</button>
                </form>

                <p class="text-secondary small mt-3 mb-0">Already registered? <a href="{{ route('login.form') }}">Login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
