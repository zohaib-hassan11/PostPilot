# Social Hub

**Post once. Publish everywhere.**
Upload a video or write a post one time — Social Hub publishes it to every connected social platform,
with its title, description, tags, thumbnail and privacy, on schedule.

Self-hosted, built with **Laravel 12 + Inertia + Vue 3 + Tailwind CSS 4**.

## Status

| Area | State |
|---|---|
| Scheduling, calendar, media library, queue | ✅ |
| Facebook Pages, X (Twitter), Mastodon | ✅ |
| Video details (title, description, tags, thumbnail, privacy) | ✅ |
| Purple / black / white design system (`Components/UI`) | ✅ |
| YouTube, Instagram Reels, TikTok, LinkedIn | 🚧 planned |
| AI titles & descriptions per platform | 🚧 planned |

## Requirements

PHP ≥ 8.3 (with `bcmath curl gd intl mbstring pcntl pdo_mysql redis xml zip`), Composer, Node 20+, MySQL/MariaDB,
Redis ≥ 6.2, FFmpeg (video thumbnails). Production also needs Supervisor and a cron entry.

## Local setup

```bash
composer install
cp .env.example .env && php artisan key:generate      # then set DB_* and APP_URL in .env
php artisan migrate
php artisan mixpost-auth:create                        # first user (or create one in tinker)

# frontend packages (our forked UI lives in packages/)
(cd packages/mixpost && npm install && npm run build)
(cd packages/mixpost-auth && npm install && npm run build)
php artisan mixpost:publish-assets --force=true
php artisan vendor:publish --tag=mixpost-auth-assets --force

# run (3 processes)
php artisan serve --port=8100        # http://localhost:8100
php artisan horizon                  # queue that publishes posts
php artisan schedule:work            # runs scheduled posts on time
```

## Tests

```bash
php artisan test        # uses the separate database `social_hub_testing` (see phpunit.xml)
```

## Project layout

| Path | What |
|---|---|
| `packages/mixpost/` | Core app (forked, MIT). Backend `src/`, frontend `resources/js/`. |
| `packages/mixpost/resources/js/Components/UI/` | **Design system** — Button, Card, PageHeader, Badge, Alert, EmptyState, StatCard, FormField, TagInput. See its README. |
| `packages/mixpost/src/Support/VideoDetails.php` | Video metadata value object (rules + normalisation) shared by all video platforms. |
| `packages/mixpost-auth/` | Login (forked, MIT). |
| `database/migrations/` | App migrations (incl. `video_details`). |
| `tests/Feature/` | Feature tests. |

After changing anything under `packages/*/resources`, rebuild that package (`npm run build`) and re-publish its assets.

## License & credits

See [NOTICE.md](NOTICE.md). Social Hub is built on Mixpost Lite (MIT License).
