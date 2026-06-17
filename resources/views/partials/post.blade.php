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
