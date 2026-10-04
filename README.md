# Laravel Mobile Menu

Переиспользуемый Blade-компонент мобильного меню (гамбургер) для Laravel-проектов. Самодостаточный, без рантайм-зависимостей, тематизируется через CSS-переменные.

## Установка

### Локальная разработка (path repository)

В `composer.json` вашего проекта:

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
        "asmi046/laravel-mobile-menu": "@dev"
    }
}
```

```bash
composer update asmi046/laravel-mobile-menu
php artisan vendor:publish --tag=mobile-menu-scss
php artisan vendor:publish --tag=mobile-menu-js
```

### Из GitHub (после публикации)

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/asmi046/laravel-mobile-menu.git"
        }
    ],
    "require": {
        "asmi046/laravel-mobile-menu": "^1.0"
    }
}
```

```bash
composer require asmi046/laravel-mobile-menu
php artisan vendor:publish --tag=mobile-menu-scss
php artisan vendor:publish --tag=mobile-menu-js
```

ServiceProvider подхватывается автоматически через `extra.laravel.providers` — никаких правок в `config/app.php` не нужно.

## Использование

### По умолчанию — через пропы

```blade
<x-mobile-menu
    :items="$navigation"
    :phone="$contacts['phone']"
    :phone-link="$contacts['phone_link']"
    :email="$contacts['email']"
/>
```

Компонент автоматически рендерит:

- `<nav>` со списком `<ul>` из `items`
- `<div>` со ссылками phone + email

### Кастомные слоты — полный контроль

Перезаписывайте любую секцию по имени. Что не заменено, рендерится по пропами.

```blade
<x-mobile-menu :items="$navigation">
    {{-- Заменяет авто-сгенерированный список навигации --}}
    <x-slot:header>
        <img src="/logo.svg" alt="">
        <p>Добро пожаловать!</p>
    </x-slot:header>

    {{-- Заменяет авто-сгенерированный блок phone/email --}}
    <x-slot:contacts>
        <a href="tel:+71234567890" class="my-phone">+7 (123) 456-78-90</a>
        <div class="my-social">
            <a href="https://t.me/...">Telegram</a>
            <a href="https://wa.me/...">WhatsApp</a>
        </div>
    </x-slot:contacts>

    {{-- Добавляет секцию внизу (без дефолта) --}}
    <x-slot:footer>
        <p>© 2025 Компания. Все права защищены.</p>
    </x-slot:footer>
</x-mobile-menu>
```

### Полная замена — default-слот

Передайте контент напрямую, чтобы переопределить всё содержимое меню.

```blade
<x-mobile-menu>
    <div class="my-custom-menu">
        <h2>Моё меню</h2>
        <a href="/home">Главная</a>
        <a href="/about">О нас</a>
        <button>Войти</button>
    </div>
</x-mobile-menu>
```

### Приоритет

1. Если передан default-слот → рендерится только его содержимое (именованные слоты игнорируются)
2. Иначе если передан слот `header` → используется вместо авто-сгенерированного `<nav>`
3. Иначе если передан слот `contacts` → используется вместо авто-сгенерированных phone/email
4. Слот `footer` всегда опционален — без дефолта
5. Любая незатронутая секция fallback на пропы

### Пропы

| Проп         | Тип    | По умолчанию     | Описание                                      |
| ------------ | ------ | ---------------- | --------------------------------------------- | ------------------------------------ |
| `items`      | array  | `[]`             | Пункты меню, каждый с ключами `url` и `label` |
| `phone`      | string | null             | `null`                                        | Телефон для отображения              |
| `phoneLink`  | string | null             | `null`                                        | `tel:` href (по умолчанию = `phone`) |
| `email`      | string | null             | `null`                                        | Email (рендерит `mailto:` ссылку)    |
| `id`         | string | `'mobile-menu'`  | DOM-id элемента `<aside>`                     |
| `openLabel`  | string | `'Открыть меню'` | ARIA-label в закрытом состоянии               |
| `closeLabel` | string | `'Закрыть меню'` | ARIA-label в открытом состоянии               |
| `align`      | string | `'right'`        | Направление выезда: `'right'` или `'left'`    |

### Слоты

| Слот       | Заменяет                                      |
| ---------- | --------------------------------------------- |
| (default)  | Всё содержимое меню целиком                   |
| `header`   | Авто-сгенерированный `<nav>` из пропа `items` |
| `contacts` | Авто-сгенерированный блок phone/email         |
| `footer`   | (нет дефолта — только добавление)             |

## Стили

Пакет использует префикс классов `mm-` и CSS-переменные для тематизации. Переопределите в основном SCSS:

```scss
:root {
    --mm-color-primary: #c1ab74;
    --mm-color-text: #1d1d1b;
    --mm-radius-full: 50%;
    --mm-z-burger: 500;
}
```

Доступные переменные:

- `--mm-color-primary` — цвет бургера и акцентов
- `--mm-color-text` — цвет текста
- `--mm-color-white` — белый
- `--mm-color-bg-light` — светлый фон разделителей
- `--mm-shadow` — тень бургера
- `--mm-shadow-sidebar` — тень панели
- `--mm-radius-full`, `--mm-radius-card` — радиусы
- `--mm-z-overlay`, `--mm-z-menu`, `--mm-z-burger` — z-index слоёв
- `--mm-transition` — длительность анимаций
- `--mm-width`, `--mm-min-width`, `--mm-max-width` — размеры панели

## JavaScript

Пакет автоматически инициализируется при подключении. Никакого глобального состояния, jQuery или настройки. Биндится к элементам с data-атрибутами:

- `[data-mm-toggle]` — кнопка-бургер
- `[data-mm-overlay]` — затемняющий фон
- `[data-mm-menu]` — элемент `<aside>` меню

Escape, клик по оверлею и клик по ссылке внутри меню — всё закрывают меню автоматически.

## Совместимость

- PHP ^8.1
- Laravel 10, 11, 12, 13
- Все современные браузеры (CSS Grid, CSS variables, `position: fixed`)

## Лицензия

MIT
