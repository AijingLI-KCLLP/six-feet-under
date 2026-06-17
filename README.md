# Six Feet Under

A real-time anonymous wall (Laravel 13 + Reverb). Write a thought, it pops up instantly on everyone else's screen; at the 6th kudo, it vanishes.


## Requirements

- **PHP 8.4+** and **Composer**
- **Node.js 18+** and **npm**
- **SQLite** (ships with PHP, nothing to install)

Check:

```bash
php --version
composer --version
node --version
```

## Installation

```bash
git clone <repo-url> six-feet-under
cd six-feet-under
composer setup
```

The `composer setup` script runs:

1. `composer install`
2. Copies `.env.example` → `.env` (if missing)
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install` + `npm run build`

> If the SQLite file doesn't exist yet: `touch database/database.sqlite` before `php artisan migrate`.

## Run locally

One command is enough:

```bash
composer run dev
```

It launches simultaneously (via `concurrently`):

- `php artisan serve` — HTTP server on `http://localhost:8000`
- `php artisan queue:listen` — job worker (broadcasts go through the queue)
- `php artisan reverb:start` — WebSocket server (real-time)
- `npm run dev` — Vite (hot reload for assets)

Then open **http://localhost:8000**. To see real-time in action, open two tabs side by side: what you post on the left shows up on the right without refreshing.

> Optional — scheduled tasks (Part 7 of the TP), in a separate terminal:
> ```bash
> php artisan schedule:work
> ```

## Useful commands

```bash
php artisan migrate:fresh   # start from an empty database
php artisan tinker          # Laravel REPL
composer run test           # run the test suite
```

## Troubleshooting

- **`419` on submit** — missing `@csrf`, or no `X-CSRF-TOKEN` header on the fetch.
- **No real-time updates on the other tab** — Reverb or the queue isn't running; restart `composer run dev`.
- **`403` from Echo in the console** — presence channel `void` authorization (see `routes/channels.php`).
- **`.env` changes have no effect** — run `php artisan config:clear`, then restart the terminals.
