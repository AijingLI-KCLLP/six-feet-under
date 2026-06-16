//
import './echo.js';

window.currentSouls = 0;

window.Echo.channel('the-void')

    .listen('PostCreated', (e) => {
        const wall = document.getElementById('wall');
        if (!wall) return;

        const card = document.createElement('div');
        card.id = `post-${e.id}`;
        card.className = 'post-card border-b border-[#111] py-8 flex flex-col gap-6';
        card.innerHTML = `
            <p class="text-[#c8c8c3] font-light text-base leading-relaxed">${e.body}</p>
            <div class="flex items-center justify-between">
                <button
                    onclick="sendKudo(${e.id}, event)"
                    class="kudo-btn flex items-center gap-2 border border-[#1e1e1e] text-[#444] text-[0.7rem] tracking-wide px-3 py-1.5 rounded-sm hover:border-[#444] hover:text-[#e8e8e3] transition-all"
                >
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span id="kudos-${e.id}">${e.kudos}</span>
                </button>
                <div id="pips-${e.id}" class="flex gap-1 items-center">
                    ${buildPips(e.kudos)}
                </div>
            </div>
        `;
        wall.prepend(card);
    })

    .listen('PostKudoed', (e) => {
        flipKudoCounter(e.id, e.kudos);

        const pips = document.getElementById(`pips-${e.id}`);
        if (pips) pips.innerHTML = buildPips(e.kudos);
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

function buildPips(kudos) {
    let html = '';
    for (let i = 0; i < 6; i++) {
        const filled = i < kudos ? 'bg-[#8b0000]' : 'bg-[#1e1e1e]';
        html += `<div class="w-4 h-0.5 rounded-full transition-all duration-300 ${filled}"></div>`;
    }
    return html;
}

function flipKudoCounter(postId, newValue) {
    const el = document.getElementById(`kudos-${postId}`);
    if (!el) return;
    el.innerHTML = `<span class="kudo-flip">${newValue}</span>`;
    setTimeout(() => { el.textContent = newValue; }, 300);
}    

function updateSoulCount(count) {
    window.currentSouls = count;
    const el = document.getElementById('soul-count');
    if (el) el.textContent = count;
}

window.sendKudo = function (postId, event) {
    addRipple(event);
    fetch(`/posts/${postId}/kudo`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    });
};

function addRipple(event) {
    const btn = event.currentTarget;
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top  - size / 2;

    const ripple = document.createElement('span');
    ripple.className = 'ripple';
    ripple.style.cssText = `width:${size}px; height:${size}px; left:${x}px; top:${y}px`;
    btn.appendChild(ripple);

    setTimeout(() => ripple.remove(), 500);
}
