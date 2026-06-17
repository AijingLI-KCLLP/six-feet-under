import './echo.js';

window.Echo.channel('the-void')
    .listen('PostCreated', (e) => { // browser wait for event type PostCreated
        const wall = document.getElementById('wall');
        if (!wall) return;
        if (document.getElementById(`post-${e.id}`)) return;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        const card = document.createElement('article');
        card.id = `post-${e.id}`;
        card.className = 'post';
        card.innerHTML = `
            <p class="post-body"></p>
            <form method="POST" action="/posts/${e.id}/kudo" class="kudo-form">
                <input type="hidden" name="_token" value="${csrf}">
                <button type="submit" class="kudo-btn" aria-label="Give a kudo">
                    <span class="kudo-heart">&#9829;</span>
                    <span id="kudos-${e.id}" class="kudo-count">${e.kudos}</span>
                    <span class="kudo-goal">/ 6</span>
                </button>
            </form>
        `;
        card.querySelector('.post-body').textContent = e.body;
        wall.prepend(card);
    })
    .listen('PostKudoed', (e) => {
        const el = document.getElementById(`kudos-${e.id}`);
        if (el) el.textContent = e.kudos;
    })
    .listen('PostVanished', (e) => {
        const card = document.getElementById(`post-${e.id}`);
        if (card) card.remove();
    });
