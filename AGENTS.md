# AGENTS.md — domain-translate

## What this is
WordPress plugin for automatic client-side translation of a website based on its domain name using Google Translate JavaScript API.

## Stack
- PHP (>=8.2.0)
- WordPress (>=6.7)
- Google Translate JavaScript API

## Run
Upload to WordPress plugins dir, activate, configure under Settings > Domain-Translate.

## Structure
- `domain-translate/` — WordPress plugin (PHP)
  - `domain-translate.php` — main plugin file
  - `src/` — PHP source
  - `js/` — JavaScript (Google Translate integration)
  - `css/` — styles
  - `languages/` — i18n files
- `test/` — Docker test environment
- `pages/` — plugin page assets

## Conventions
- No comments in code unless asked.
- Verify: `php -l domain-translate/domain-translate.php`
