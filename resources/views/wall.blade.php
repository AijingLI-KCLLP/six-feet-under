<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Six Feet Under</title>
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
