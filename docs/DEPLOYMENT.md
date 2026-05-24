# Deployment Guide

This document explains how to run and publish Seminar Manager in a practical environment.

## Local Development

### Requirements

- PHP 8.4
- Composer
- Node.js and npm
- SQL Server or another supported database

### Install

```bash
composer install
npm install
```

### Environment setup

```bash
copy .env.example .env
php artisan key:generate
```

If you want to use the seeded local demo mode on this machine, keep the SQL Server settings in `.env` and make sure the `seminar_manager` database exists.

### Database

```bash
php artisan migrate:fresh --seed
```

### Switching to SQL Server

Yes, Seminar Manager can run on SQL Server.

The project already includes a `sqlsrv` connection in `config/database.php`, so you only need to update environment settings and make sure the SQL Server PHP driver is installed.

Use this kind of `.env` setup:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=seminar_manager
DB_USERNAME=sa
DB_PASSWORD=your_password
DB_ENCRYPT=yes
DB_TRUST_SERVER_CERTIFICATE=yes
```

Notes:

- keep `SESSION_DRIVER=file` if you do not want sessions stored in the database
- `CACHE_STORE=file` is also the easiest option during development
- if you want database-backed sessions and cache on SQL Server, run the session/cache migrations on that connection
- make sure the Microsoft ODBC driver and the `pdo_sqlsrv` / `sqlsrv` PHP extensions are installed

### Frontend assets

```bash
npm run dev
```

### Run the app

```bash
php artisan serve
```

Open:

- `http://127.0.0.1:8000`

## Production Checklist

Before deployment, review these items:

- set `APP_ENV=production`
- set `APP_DEBUG=false`
- use the SQL Server demo database or another real database
- configure a production mail driver
- configure queue workers if you want background processing
- run `php artisan migrate --force`
- build frontend assets with `npm run build`
- create the storage symlink with `php artisan storage:link`

## Suggested Hosting Options

The project can be deployed on common PHP hosting or cloud platforms that support:

- Laravel 13
- PHP 8.4
- persistent storage
- a relational database

Suitable options include:

- shared hosting with Laravel support
- VPS or cloud server
- Laravel-friendly platforms such as Railway, Render, or Forge-managed servers

## AI Chat Environment Variables

If you want the cloud-backed AI assistant to work, configure:

```env
OPENAI_API_KEY=your_key_here
OPENAI_MODEL=gpt-4.1-mini
OPENAI_BASE_URL=https://api.openai.com/v1
```

If `OPENAI_API_KEY` is not set, Seminar Manager falls back to a local demo assistant so the chat still works for classroom demos.

## Common Troubleshooting

### Login page returns 500

- check that the SQL Server database exists
- run migrations and seeders again
- make sure `SESSION_DRIVER=database` has a working database

If you switch to SQL Server, also check:

- SQL Server service is running
- PHP SQL Server extensions are installed
- the credentials in `.env` are correct

### AI chat returns configuration error

- make sure `OPENAI_API_KEY` is set
- verify network access to the OpenAI API

### Frontend analytics or AI chat do not load

- run `npm install`
- run `npm run dev` during local development
- use `npm run build` for production

## Final Note

For this seminar project, the local SQL Server demo setup is usually enough for classroom presentation, but the checklist above makes it ready to move toward production if needed.
