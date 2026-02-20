<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Exam Validator' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --uni-primary: #0f3d7a;
            --uni-accent: #1f6fd1;
            --uni-bg: #f4f8fc;
            --uni-surface: #ffffff;
            --uni-muted: #6b7280;
        }

        body {
            background: linear-gradient(180deg, #f8fbff 0%, var(--uni-bg) 100%);
            color: #1f2937;
        }

        .uni-navbar {
            background: var(--uni-surface);
            border-bottom: 1px solid #d9e4f4;
            box-shadow: 0 8px 24px rgba(15, 61, 122, 0.05);
        }

        .uni-brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--uni-accent);
            display: inline-block;
            margin-right: 8px;
        }

        .page-shell {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .uni-page-title {
            color: var(--uni-primary);
            font-weight: 700;
            letter-spacing: .3px;
        }

        .uni-subtitle {
            color: var(--uni-muted);
            margin-bottom: 1rem;
        }

        .card {
            border: 1px solid #e1e9f5;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(15, 61, 122, 0.04);
        }

        .table thead th {
            background: #f2f7ff;
            color: #0f3d7a;
            border-bottom: 1px solid #d7e4f8;
            font-weight: 600;
        }

        .uni-kpi {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--uni-primary);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg uni-navbar">
    <div class="container-fluid page-shell my-0 py-0">
        <a class="navbar-brand fw-semibold text-primary" href="#">
            <span class="uni-brand-dot"></span>Exam Validator
        </a>

        @auth
            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary small">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">Logout</button>
                </form>
            </div>
        @endauth
    </div>
</nav>

<main class="page-shell">
    @if (session('status'))
        <div class="alert alert-info border-0 shadow-sm">{{ session('status') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
