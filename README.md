# Kakoma Secondary School Website

Official website for Kakoma Secondary School (Rakai District, Uganda), built
for the school's Diamond Jubilee (60th anniversary) on **14 November 2026**,
and designed to keep serving as the school's living website long after.

Plain PHP + SQLite — no framework, no build step, no Composer. Deploys to
any standard shared PHP host.

## Requirements

- PHP 8.0+ with the `pdo_sqlite` and `gd` extensions enabled (both are part
  of a standard PHP install / most shared hosting stacks).
- Apache with `mod_rewrite`/`.htaccess` support (recommended), or any web
  server that can route requests to `.php` files directly. No `.htaccess`
  processing is required for the site to function — it's used only for
  directory-listing protection, denying direct access to `/data`,
  `/database`, `/includes`, and a friendly 404 page.

## Local development

```bash
php -S localhost:8000
```

Then visit `http://localhost:8000`. The SQLite database at `data/kakoma.sqlite`
is created and seeded automatically on first request — nothing to configure.

## Deploying

1. Upload the whole project to your hosting account's web root (e.g. the
   `public_html` folder for `kakomass.com`).
2. Make sure `data/` is writable by the web server (`chmod 775 data`) — this
   is where the SQLite database lives.
3. Visit the site once to trigger the automatic database setup.
4. Log into `/admin/` (see credentials below) and **change the default
   password immediately** under "My Account".

## Admin / CMS

Visit `/admin/` to manage content without touching code:

- **Blog Posts** — publish "Recent Activities" posts (the fundraising
  dinner write-up is pre-loaded as the first post).
- **Events** — add/edit upcoming events; mark them "Coming Soon" until
  confirmed, as with the Diamond Jubilee itself.
- **Old Students** — review, approve, and feature Old Student
  registrations submitted through the public site.
- **Gallery** — upload photos directly, or bulk-import photos already
  placed in `assets/photos/<album>/` alongside a `captions.csv` (see
  below).
- **Messages** — read contact form submissions and the E-Learning
  interest list.

**Default login (change this immediately after first login):**
- Username: `admin`
- Password: `KakomaJubilee2026!`

## Adding photos in bulk

Each album folder under `assets/photos/` (`dinner/`, `rakai/`, `campus/`)
follows this convention: drop your photos into the folder, then add/update
`captions.csv` in that same folder with columns:

```
filename,caption,people,date,location
```

Then in `/admin/gallery`, click **"Import from `<album>`/captions.csv"**.
This creates optimized thumbnails automatically and adds the photos to the
public gallery — matching photos to captions by filename, never by
guesswork.

## Project structure

```
config.php              Site-wide settings: colors, dates, contact info, nav
includes/                Shared PHP includes (header, footer, nav, db, helpers)
database/schema.sql      SQLite schema
database/seed.php        First-run seed data (dinner post, event, gallery)
database/migrations.php  One-time content/schema fixups, applied automatically
                         on every request — safe to deploy on top of a live,
                         already-seeded site (see comments in the file)
assets/css/style.css     Public site styles (navy + gold, mobile-first)
assets/css/admin.css     Admin panel styles
assets/js/main.js        Mobile nav, countdown, gallery lightbox
assets/photos/<album>/   Photos + captions.csv per the captioning convention
assets/logo/             School crest
admin/                   Session-protected CMS (see admin/includes/bootstrap.php)
*.php (root)             One file per public page — see sitemap below
```

## Clean URLs

Every page is reachable without its `.php` extension (e.g. `/anniversary`,
not `/anniversary.php`) via rewrite rules in `.htaccess`. A request for the
old `.php` URL 301-redirects to the clean one, so old links/bookmarks still
work. This requires `mod_rewrite` (standard on virtually all shared PHP
hosting) — if it's ever unavailable, the site still works, just with visible
`.php` extensions.

## Sitemap status

**Phase 1 (live now):** Home, Kakoma at 60, Our History, Board Message,
Head Teacher's Message, Old Students/Alumni + registration, Digital
Magazine, Gallery, Blog, Events, Contact.

**Phase 2 (teaser/coming soon, ready to expand):** E-Learning (with
interest capture), Academics & Admissions, Give/Support.

## Open items to confirm with the school

- **Brand colors**: `config.php` defines `COLOR_NAVY` / `COLOR_GOLD` sampled
  from the crest graphic on hand — confirm against official brand
  guidelines if/when supplied, then update `config.php` and
  `assets/css/style.css`'s `:root` variables together.
- **Contact details**: phone/address/map in `config.php` are placeholders —
  update `SCHOOL_PHONE`, `SCHOOL_ADDRESS`, `SCHOOL_MAP_QUERY`.
- **Digital Magazine**: `magazine.php` shows a "Coming Soon" placeholder
  until a PDF is placed at `assets/magazine/kakoma-diamond-jubilee-magazine.pdf`
  (or an embed URL is set in `$magazineEmbedUrl` in that file).
- **History page**: `history.php` includes what's confirmed so far (1967
  founding, Kingdom of Kooki land gift); expand it once founding-family
  names and Rakai interview material are compiled.
- **Rakai / campus photos**: folders and `captions.csv` templates are ready
  at `assets/photos/rakai/` and `assets/photos/campus/` — add photos and
  captions, then import via the admin Gallery page.
- **Hosting**: this is a plain PHP+SQLite app, compatible with most shared
  hosting; confirm final hosting target for `kakomass.com`.
