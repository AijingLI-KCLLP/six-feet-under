import './echo.js';

const setSoulCount = (n) => {
    const el = document.getElementById('soul-count');
    if (el) el.textContent = n;
};

document.addEventListener('submit', (event) => {
    const form = event.target.closest('.kudo-form');
    if (!form) return;
    event.preventDefault();

    const token = form.querySelector('input[name="_token"]')?.value
        ?? document.querySelector('meta[name="csrf-token"]')?.content
        ?? '';

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
    }).catch(() => {});
});

window.Echo.join('the-void')
    .here((users) => setSoulCount(users.length))
    .joining((_, users) => setSoulCount(users.length))
    .leaving((_, users) => setSoulCount(users.length));

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
        if (!card) return;

        card.classList.add('post--vanishing');
        const overlay = document.createElement('div');
        overlay.className = 'post-vanish-overlay';
        overlay.innerHTML = '<span class="post-vanish-spinner" aria-hidden="true"></span>';
        card.appendChild(overlay);

        const audio = new Audio('/assets/sounds/vanish.mp3');
        const remove = () => card.remove();

        // Hold the spinner for the audio's duration (regardless of autoplay block)
        const armTimer = () => {
            const seconds = isFinite(audio.duration) && audio.duration > 0 ? audio.duration : 1.5;
            setTimeout(remove, seconds * 1000);
        };
        if (audio.readyState >= 1) armTimer();
        else {
            audio.addEventListener('loadedmetadata', armTimer, { once: true });
            audio.addEventListener('error', () => setTimeout(remove, 1500), { once: true });
        }

        audio.play().catch(() => {}); // autoplay blocked → silent
    });
