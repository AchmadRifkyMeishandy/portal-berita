# Portal Berita Sepakbola

A football news portal and content management system (CMS) built with Laravel. This project is being developed as a learning and portfolio project to practice backend development, database design, authorization, and automated testing.

> **Project status:** In development. The article CMS workflow is being built first. The public-facing news pages and several supporting modules are still on the roadmap.

## Overview

The goal of this project is to build a portal where readers can browse football news and an editorial team can manage articles through a clear review and publishing process.

The planned editorial workflow is:

`Draft → Review → Approved → Published`

An editor can also return an article for revision. The journalist can update the draft and submit it for review again.

## Tech Stack

- **Backend:** PHP 8.3, Laravel 12
- **Admin panel:** Filament 5
- **Database:** MySQL
- **Roles and permissions:** Spatie Laravel Permission
- **Frontend assets:** Blade, Tailwind CSS, Vite
- **Testing:** PHPUnit / Laravel test runner
- **Local development:** Laragon, Composer, Node.js and npm

## Current Features

### Implemented or under active development

- Article model and database relationships.
- Article statuses: Draft, Review, Approved, and Published.
- Article submission for editorial review.
- Editor approval, publishing, and return-for-revision workflow.
- Revision notes for articles returned to journalists.
- Role and permission setup for Super Admin, Editor, Journalist, and Reader.
- Article management table in Filament, including status filtering, search, sorting, and configurable columns.
- Soft delete and restore support for articles.
- Policy-based authorization for article actions.
- Automated tests for core article workflow rules and test database configuration.

The latest locally reported test run passed **10 tests with 25 assertions**. This is a development test result, not a claim that every planned feature has been tested.

## Roadmap

- [x] Project foundation, models, database relationships, factories, and seed data
- [x] Core article lifecycle and authorization rules
- [x] Article table improvements and status filtering
- [ ] Finish and review CMS authorization and automated test coverage
- [ ] Category and tag management
- [ ] Media and featured-image management
- [ ] Public homepage and article listing pages
- [ ] Article detail pages, related news, and search
- [ ] Author profiles
- [ ] Comments and moderation
- [ ] Likes and bookmarks
- [ ] SEO improvements
- [ ] Activity logs and application settings
- [ ] Final security, performance, and deployment review

The roadmap may change as the project develops. The detailed learning and implementation checklist is maintained separately in `docs/ROADMAP.md`.

## Getting Started

### Requirements

Install the following tools before running the project:

- PHP 8.3 or a compatible version required by the project dependencies
- Composer
- MySQL
- Node.js and npm
- Git

### 1. Clone the repository

```bash
git clone https://github.com/AchmadRifkyMeishandy/portal-berita.git
cd portal-berita
```

If the project is still private, you must have repository access to clone it.

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create your local environment file

Copy `.env.example` to `.env`.

On Windows Command Prompt:

```bat
copy .env.example .env
```

On Git Bash, macOS, or Linux:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure MySQL

Create a local MySQL database for the application, for example `portal_berita`. Update the database settings in your local `.env` file. Example values are shown below; replace the username and password with your own local database credentials.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_berita
DB_USERNAME=root
DB_PASSWORD=
```

Do not commit your `.env` file or real credentials.

### 5. Run migrations and seed development data

```bash
php artisan migrate --seed
```

This runs the migrations and the seeders configured for the application. Use development data only in a local development database. Do not run seeders against a production database without reviewing their contents first.

### 6. Install frontend dependencies

```bash
npm install
npm run build
```

During development, you can run the Vite development server instead of building assets:

```bash
npm run dev
```

### 7. Create the public storage link

```bash
php artisan storage:link
```

### 8. Start the Laravel development server

```bash
php artisan serve
```

Open the local URL shown in the terminal. The Filament admin panel is available at `/admin` when the local database and user setup are configured correctly.

## Running Tests

Run the automated test suite with:

```bash
php artisan test
```

The test environment is configured separately in `phpunit.xml`. Make sure its configured test database exists and is separate from your development database before running tests. Do not point the test environment at a database containing data you want to keep.

## Screenshots

Screenshots will be added as the admin UI and public-facing pages become more complete. Suggested files:

- `docs/images/article-table.png`
- `docs/images/article-editor.png`
- `docs/images/public-homepage.png`

## Security Notes

- Keep `.env` out of Git. Use `.env.example` for safe example configuration only.
- Do not publish real passwords, API tokens, private keys, or production database details.
- Development accounts and seeded data are for local testing only. Do not use development credentials in production.
- This project is under active development and has not yet been presented as a production-ready service.

## Author

**Achmad Rifky Meishandy**

GitHub: [@AchmadRifkyMeishandy](https://github.com/AchmadRifkyMeishandy)

---

This project is built for learning and portfolio purposes. Features, screenshots, and setup instructions will be updated as development continues.
