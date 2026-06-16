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

    /* --- Base --- */
    body { font-family: 'Inter', sans-serif; font-weight: 300; }
    .font-serif-elegant { font-family: 'Cormorant Garamond', serif; }

    /* --- 1. Glitch sur le titre --- */
    @keyframes glitch {
        0%, 90%, 100% { transform: translate(0); clip-path: none; }
        91%  { transform: translate(-2px, 1px); clip-path: inset(20% 0 60% 0); }
        92%  { transform: translate(2px, -1px); clip-path: inset(60% 0 10% 0); }
        93%  { transform: translate(-1px, 2px); clip-path: inset(40% 0 30% 0); }
        94%  { transform: translate(0); clip-path: none; }
    }
    .glitch {
        position: relative;
        animation: glitch 5s infinite;
    }
    .glitch::before,
    .glitch::after {
        content: attr(data-text);
        position: absolute;
        inset: 0;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: inherit;
        font-weight: 300;
    }
    .glitch::before {
        color: #ff000055;
        animation: glitch 5s infinite 0.05s;
        clip-path: inset(30% 0 50% 0);
    }
    .glitch::after {
        color: #8b000044;
        animation: glitch 5s infinite 0.1s;
        clip-path: inset(60% 0 20% 0);
    }

    .kudo-btn { position: relative; overflow: hidden; }
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(139, 0, 0, 0.3);
        transform: scale(0);
        animation: rippleAnim 0.5s ease-out forwards;
        pointer-events: none;
    }
    @keyframes rippleAnim {
        to { transform: scale(4); opacity: 0; }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); filter: blur(4px); }
        to   { opacity: 1; transform: translateY(0);    filter: blur(0); }
    }
    .post-card { animation: slideIn 0.5s ease forwards; }

    @keyframes flipUp {
        0%   { opacity: 1; transform: translateY(0); }
        40%  { opacity: 0; transform: translateY(-6px); }
        60%  { opacity: 0; transform: translateY(6px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .kudo-flip {
        display: inline-block;
        animation: flipUp 0.3s ease forwards;
    }

    /* --- Vanish --- */
    @keyframes vanish {
        0%   { opacity: 1; max-height: 300px; filter: blur(0); }
        60%  { opacity: 0; filter: blur(6px); }
        100% { opacity: 0; max-height: 0; padding: 0; }
    }
    .vanishing {
        animation: vanish 0.7s ease forwards;
        overflow: hidden;
    }

    @keyframes breathe {
        0%, 100% { opacity: 0.2; transform: scale(1); }
        50%       { opacity: 1;   transform: scale(1.4); }
    }
    .soul-dot { animation: breathe 2s ease-in-out infinite; }
</style>

</head>
<body class="bg-[#0d0808] text-[#e8e8e3] min-h-screen">

    {{-- Header --}}
    <header class="border-b border-[#1a1a1a] px-10 py-6 flex items-center justify-between">
        <span class="glitch font-serif-elegant italic text-2xl tracking-wide font-light" data-text="Six Feet Under">
            Six Feet Under
        </span>
        <span class="flex items-center gap-2 text-[#444] uppercase tracking-[0.2em] text-[0.65rem]">
            <span class="soul-dot w-1.5 h-1.5 rounded-full bg-[#8b0000]"></span>
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
                <em class="text-[#8b0000]">Then vanish.</em>
            </p>

            <form method="POST" action="/posts" class="mt-auto flex flex-col gap-4">
                @csrf
                <span class="uppercase tracking-[0.25em] text-[#444] text-[0.65rem]">Your thought</span>
                <textarea
                    name="body"
                    maxlength="280"
                    placeholder="Something you have never said out loud..."
                    class="bg-transparent border border-[#222] text-[#e8e8e3] font-light text-sm leading-relaxed p-4 resize-none h-32 rounded-sm outline-none placeholder-[#333] focus:border-[#8b0000] transition-colors"
                ></textarea>
                <button
                    type="submit"
                    class="border border-[#8b0000] text-[#8b0000] uppercase tracking-[0.2em] text-[0.7rem] py-3 rounded-sm hover:bg-[#8b0000] hover:text-white transition-all"
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
                            onclick="sendKudo({{ $post->id }}, event)"
                            class="kudo-btn flex items-center gap-2 border border-[#1e1e1e] text-[#444] text-[0.7rem] tracking-wide px-3 py-1.5 rounded-sm hover:border-[#8b0000] hover:text-[#ff4444] transition-all"
                        >
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span id="kudos-{{ $post->id }}">{{ $post->kudos }}</span>
                        </button>
                        <div class="flex gap-1 items-center">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="w-4 h-0.5 rounded-full {{ $i < $post->kudos ? 'bg-[#8b0000]' : 'bg-[#1e1e1e]' }}"></div>
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
