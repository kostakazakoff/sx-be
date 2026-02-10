# GiG Construction API


API-first Laravel 12 backend for managing projects, media, and client inquiries with multilingual support.

## Features
- 🔐 Fortify authentication with Sanctum API tokens
- 🗃️ Media handling via Spatie Media Library (S3-ready)
- 🌐 Translation loader for multilingual content
- 📨 Transactional email with Symfony Mailer (Mailgun)
- ⚡ Redis-powered cache and queues (Predis)
- 🛠️ Developer DX: Vite dev server, Boost/Pail diagnostics, Pint formatting, Pest tests

## Tech Stack
- **Framework:** Laravel 12 (PHP 8.2)
- **Auth/Security:** Fortify, Sanctum
- **Storage:** AWS S3 (Flysystem v3), Redis/Predis
- **Media & i18n:** Spatie Media Library, Spatie Translation Loader
- **Mail:** Symfony Mailer (Mailgun)
- **Frontend tooling:** Vite 7, Tailwind CSS 4, Axios, Laravel Vite Plugin
- **QA & DX:** Pest, Laravel Pint, Laravel Boost, Pail

## Requirements
- PHP 8.2+, Composer 2.x
- Node.js 20+ and npm
- MySQL/MariaDB
- Redis (for cache/queues)

## Content & Admin
- 🖥️ Admin panel controls all frontend content (projects, services, media, copy) — nothing is hardcoded; the site is fully updatable by administrators.

## Inquiries & Communications
- 📨 Inquiry forms support Bulgarian and English; replies are sent in the customer's chosen language.
- 📢 Broadcast email campaigns to selected client groups, delivered in each recipient's preferred language.
