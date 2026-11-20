# TSA3 — Ember Daily — Tasks for Today

GitHub source: [IT0049-TSA3](https://github.com/carrilloklyde-a11y/IT0049-TSA3). When cloning this repository, follow **Fresh installation** below.

This is the independent **TSA3** project. It has its own installed dependencies, environment settings, and SQLite database.

## Run locally

1. Double-click **START.cmd** in this folder.
2. Open <http://127.0.0.1:8003>.
3. Keep the launcher window open while using the app; press Ctrl+C to stop it.

No assessment selection is needed. Each assessment has a different port, so all three can run together. Restarting preserves existing data.

## Assignment implementation

Four required pages: `/` for today’s tasks, `/tasks` for every task ordered by date, `/profile`, and `/about`. Includes 10 initially seeded tasks across three dates, exactly one profile, Eloquent models, migrations, seeders, and task management controls. Today uses Asia/Manila time. Your existing profile and tasks were preserved.

## Fresh installation

The prepared folder already includes the installed libraries and database. For a fresh source-only copy, install PHP 8.2 or newer and Composer 2, then run the following commands from this directory:

```sh
composer install
```

Copy `.env.example` to `.env`, then run:

```sh
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8003
```

On this computer, use `C:\xampp\php\php.exe` instead of `php` when PHP is not in PATH. No frontend build is needed.

## Checks

```sh
php artisan test
php artisan route:list --except-vendor
```

The retained [reference guide](REFERENCE-GUIDE.md) contains the original detailed objective mapping and implementation notes. Its original shared-folder paths, mode-selection instructions, and ports are superseded by this README.

The source is prepared for a public GitHub submission. The application runs locally; a separate live hosting URL has not been deployed.
