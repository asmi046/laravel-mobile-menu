# Laravel Mobile Menu

Reusable slide-in mobile menu (hamburger) Blade component for Laravel projects. Self-contained, zero runtime dependencies, themable via CSS custom properties.

## Installation

### Local development (path repository)

In your project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../packages/laravel-mobile-menu",
            "options": { "symlink": true }
        }
    ],
    "require": {
        "advokat-potapova/laravel-mobile-menu": "@dev"
    }
}
```

```bash
composer update advokat-potapova/laravel-mobile-menu
php artisan vendor:publish --tag=mobile-menu-scss
php artisan vendor:publish --tag=mobile-menu-js
```

### From GitHub (after publishing)

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/yourname/laravel-mobile-menu.git"
        }
    ],
    "require": {
        "advokat-potapova/laravel-mobile-menu": "^1.0"
    }
}
```

```bash
composer require advokat-potapova/laravel-mobile-menu
php artisan vendor:publish --tag=mobile-menu-scss
php artisan vendor:publish --tag=mobile-menu-js
```

The package ServiceProvider is auto-discovered.

## Usage

In your layout or header partial:

```blade
<x-mobile-menu
    :items="$navigation"
    :phone="$contacts['phone']"
    :phone-link="$contacts['phone_link']"
    :email="$contacts['email']"
/>
```

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | array | `[]` | Navigation items, each with `url` and `label` keys |
| `phone` | string|null | `null` | Phone label to display |
| `phoneLink` | string|null | `null` | `tel:` href (falls back to `phone`) |
| `email` | string|null | `null` | Email address (renders `mailto:` link) |
| `id` | string | `'mobile-menu'` | DOM id of the menu `<aside>` |
| `openLabel` | string | `'Открыть меню'` | ARIA label when menu is closed |
| `closeLabel` | string | `'Закрыть меню'` | ARIA label when menu is open |
| `align` | string | `'right'` | Menu slide direction: `'right'` or `'left'` |

## Styles

The package uses a `mm-` class prefix and CSS custom properties for theming. Override defaults in your main SCSS:

```scss
:root {
    --mm-color-primary: #C1AB74;
    --mm-color-text: #1d1d1b;
    --mm-radius-full: 50%;
    --mm-z-burger: 500;
}
```

## JavaScript

The package auto-initializes when included. No global state, no jQuery, no setup needed. It binds to elements with these data attributes:
- `[data-mm-toggle]` — burger button
- `[data-mm-overlay]` — overlay backdrop
- `[data-mm-menu]` — menu `<aside>`

## License

MIT