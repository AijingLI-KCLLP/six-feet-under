<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Six Feet Under</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; padding: 3rem 1rem;
            background: #0a0a0f; color: #e7e7ea;
            font-family: ui-monospace, "SF Mono", Menlo, monospace;
            display: flex; flex-direction: column; align-items: center; gap: 1rem;
        }
        h1 {
            margin: 0;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: #b3143a;
        }
        .kudo-hint {
            margin: 0;
            font-size: .8em;
            color: #d6647e;
        }
        main {
            width: min(640px, 100%);
            display: flex; flex-direction: column; gap: 1rem;
        }
        .post {
            background: #14141c; border: 1px solid #23232e; border-radius: 12px;
            padding: 1rem 1.2rem; line-height: 1.5;
            display: flex; flex-direction: column; gap: .8rem;
        }
        .post-body { margin: 0; }
        .kudo-form { align-self: flex-end; margin: 0; }
        .kudo-btn {
            display: inline-flex; align-items: center; gap: .4rem;
            background: transparent;
            border: 1px solid #b3143a;
            color: #b3143a;
            border-radius: 999px;
            padding: .35rem .85rem;
            font: inherit; font-size: .9em;
            cursor: pointer;
            transition: background .15s, color .15s, transform .1s;
        }
        .kudo-btn:hover { background: #b3143a; color: #fff; }
        .kudo-btn:active { transform: scale(.96); }
        .kudo-heart { font-size: 1.1em; line-height: 1; }
        .kudo-goal { opacity: .55; font-size: .85em; }
        .thoughts-form { display: flex; flex-direction: column; gap: .5rem; }
        .thoughts-form textarea {
            width: 100%;
            background: #14141c; color: #e7e7ea;
            border: 1px solid #23232e; border-radius: 12px;
            padding: 1rem; font: inherit; resize: none;
        }
        .thoughts-form button {
            align-self: flex-start;
            background: #b3143a; color: #fff;
            border: 0; border-radius: 10px;
            padding: .6rem 1.2rem; font: inherit; cursor: pointer;
        }
    </style>
    @stack('styles')
</head>
<body>
    <h1>Six Feet Under</h1>
    <p>The thoughts you'd never say out loud.</p>
    <p class="kudo-hint">6 kudos will let it go.</p>


    <main id="wall">
        @foreach ($posts as $post)
            @include('partials.post', ['post' => $post])
        @endforeach

        <form method="POST" action="/posts" class="thoughts-form">
            @csrf
            <textarea name="body" maxlength="280" rows="3"
                      placeholder="Say the unsayable… careful what you wish for"></textarea>
            <button type="submit">Send</button>
        </form>
    </main>
</body>
</html>
