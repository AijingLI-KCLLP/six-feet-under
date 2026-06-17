<article id="post-{{ $post->id }}" class="post">
    <p class="post-body">{{ $post->body }}</p>
    <form method="POST" action="/posts/{{ $post->id }}/kudo" class="kudo-form">
        @csrf
        <button type="submit" class="kudo-btn" aria-label="Give a kudo">
            <span class="kudo-heart">♥</span>
            <span id="kudos-{{ $post->id }}" class="kudo-count">{{ $post->kudos }}</span>
            <span class="kudo-goal">/ 6</span>
        </button>
    </form>
</article>

@once
    @push('styles')
        <style>
            .post--vanishing { position: relative; pointer-events: none; }
            .post-vanish-overlay {
                position: absolute; inset: 0;
                background: rgba(10, 10, 15, .65);
                border-radius: 12px;
                display: flex; align-items: center; justify-content: center;
            }
            .post-vanish-spinner {
                width: 28px; height: 28px;
                border: 3px solid rgba(179, 20, 58, .25);
                border-top-color: #b3143a;
                border-radius: 50%;
                animation: post-vanish-spin .8s linear infinite;
            }
            @keyframes post-vanish-spin { to { transform: rotate(360deg); } }
        </style>
    @endpush
@endonce
