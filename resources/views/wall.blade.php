<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Six Feet Under</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; padding: 3rem 1rem;
            background: #0a0a0f; color: #e7e7ea;
            font-family: ui-monospace, "SF Mono", Menlo, monospace;
            display: flex; flex-direction: column; align-items: center; gap: 1rem;
        }
        h1 { font-weight: 600; letter-spacing: .15em; opacity: .85; }
        .post {
            width: min(640px, 100%);
            background: #14141c; border: 1px solid #23232e; border-radius: 12px;
            padding: 1rem 1.2rem; line-height: 1.5;
        }
    </style>
</head>
<body>
    <h1>Six Feet Under</h1>
    <p>The thoughts you'd never say out loud.</p>

    @foreach($thoughts as $thought)
        <div class = "post"> {{ $thought }} </div>
    @endforeach



</body>
</html>
