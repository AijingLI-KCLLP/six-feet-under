//
import './echo.js';

window.currentSouls = 0;

window.Echo.channel('the-void')

    .listen('PostCreated', (e) => {
        const wall = document.getElementById('wall');
        if (!wall) return;

        const card = document.createElement('div');
        card.id = `post-${e.id}`;
        card.className = 'post-card';
        card.innerHTML = `
            <p>${e.body}</p>
            <button onclick="sendKudo(${e.id})">
                <span id="kudos-${e.id}">${e.kudos}</span>
            </button>
        `;
        wall.prepend(card);
    })

    .listen('PostKudoed', (e) => {
        const counter = document.getElementById(`kudos-${e.id}`);
        if (counter) counter.textContent = e.kudos;
    })

    .listen('PostVanished', (e) => {
        const card = document.getElementById(`post-${e.id}`);
        if (card) {
            card.classList.add('vanishing');
            setTimeout(() => card.remove(), 600);
        }
    });

window.Echo.join('presence-the-void')

    .here((users) => {
        updateSoulCount(users.length);
    })
    .joining(() => {
        updateSoulCount(window.currentSouls + 1);
    })
    .leaving(() => {
        updateSoulCount(window.currentSouls - 1);
    });

function updateSoulCount(count) {
    window.currentSouls = count;
    const el = document.getElementById('soul-count');
    if (el) el.textContent = count;
}

window.sendKudo = function (postId) {
    fetch(`/posts/${postId}/kudo`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    });
};
