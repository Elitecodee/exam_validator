<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Exam Validator' }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f7fb; color: #1f2937; }
        .nav { background: #111827; color: #fff; padding: 12px 20px; display: flex; justify-content: space-between; }
        .container { max-width: 980px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,.08); margin-bottom: 16px; }
        .grid { display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; margin-bottom: 14px; }
        button { background: #2563eb; color: white; border: 0; border-radius: 8px; padding: 10px 14px; cursor: pointer; }
        a { color: #2563eb; text-decoration: none; }
        .muted { color: #6b7280; }
        .alert { background: #ecfeff; border: 1px solid #a5f3fc; padding: 10px; border-radius: 8px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="nav">
        <strong>Exam Validator</strong>
        <div>
            @auth
                <span style="margin-right: 10px;">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endauth
        </div>
    </div>

    <main class="container">
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
