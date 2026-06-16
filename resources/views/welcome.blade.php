<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Six Feet Under</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,300&family=Inter:wght@300;400&display=swap');

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes vanish {
            0%   { opacity: 1; max-height: 300px; }
            60%  { opacity: 0; }
            100% { opacity: 0; max-height: 0; padding: 0; }
        }
        @keyframes breathe {
            0%, 100% { opacity: 0.2; }
            50%       { opacity: 1; }
        }

        body { font-family: 'Inter', sans-serif; font-weight: 300; }
        .font-serif-elegant { font-family: 'Cormorant Garamond', serif; }
        .post-card { animation: slideIn 0.4s ease; }
        .vanishing { animation: vanish 0.6s ease forwards; overflow: hidden; }
        .soul-dot  { animation: breathe 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-[#080808] text-[#e8e8e3] min-h-screen">

    {{-- Header --}}
    <header class="border-b border-[#1a1a1a] px-10 py-6 flex items-center justify-between">
        <span class="font-serif-elegant italic text-2xl tracking-wide font-light">Six Feet Under</span>
        <span class="flex items-center gap-2 text-[#444] uppercase tracking-[0.2em] text-[0.65rem]">
            <span class="soul-dot w-1.5 h-1.5 rounded-full bg-[#444]"></span>
            <span id="soul-count" class="text-[#e8e8e3]">0</span> presence(s) in the void
        </span>
    </header>

    {{-- Layout --}}
    <div class="grid grid-cols-[1fr_1.8fr] min-h-[calc(100vh-73px)]">

        {{-- Sidebar --}}
        <aside class="border-r border-[#1a1a1a] px-10 py-12 flex flex-col gap-8 sticky top-0 h-[calc(100vh-73px)]">

            <p class="font-serif-elegant text-5xl font-light leading-tight">
                Write.<br>
                Be seen.<br>
                <em class="text-[#555]">Then vanish.</em>
            </p>

            <form method="POST" action="/posts" class="mt-auto flex flex-col gap-4">
                @csrf
                <span class="uppercase tracking-[0.25em] text-[#444] text-[0.65rem]">Your thought</span>
                <textarea
                    name="body"
                    maxlength="280"
                    placeholder="Something you have never said out loud..."
                    class="bg-transparent border border-[#222] text-[#e8e8e3] font-light text-sm leading-relaxed p-4 resize-none h-32 rounded-sm outline-none placeholder-[#333] focus:border-[#444] transition-colors"
                ></textarea>
                <button
                    type="submit"
                    class="border border-[#2a2a2a] text-[#888] uppercase tracking-[0.2em] text-[0.7rem] py-3 rounded-sm hover:border-[#555] hover:text-[#e8e8e3] transition-all"
                >
                    Release into the void
                </button>
            </form>

        </aside>

        {{-- Wall --}}
        <main class="px-10 py-12 flex flex-col">

            @forelse ($posts ?? [] as $post)
                <div id="post-{{ $post->id }}" class="post-card border-b border-[#111] py-8 flex flex-col gap-6">
                    <p class="text-[#c8c8c3] font-light text-base leading-relaxed">{{ $post->body }}</p>
                    <div class="flex items-center justify-between">
                        <button
                            onclick="sendKudo({{ $post->id }})"
                            class="flex items-center gap-2 border border-[#1e1e1e] text-[#444] text-[0.7rem] tracking-wide px-3 py-1.5 rounded-sm hover:border-[#444] hover:text-[#e8e8e3] transition-all"
                        >
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span id="kudos-{{ $post->id }}">{{ $post->kudos }}</span>
                        </button>
                        <div class="flex gap-1 items-center">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="w-4 h-0.5 rounded-full {{ $i < $post->kudos ? 'bg-[#555]' : 'bg-[#1e1e1e]' }}"></div>
                            @endfor
                        </div>
                    </div>
                </div>
            @empty
                <p class="font-serif-elegant italic text-[#2a2a2a] text-lg pt-12">The void is listening...</p>
            @endforelse

        </main>

    </div>

</body>
</html>
