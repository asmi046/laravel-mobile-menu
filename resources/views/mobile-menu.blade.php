@props([
    'items' => [],
    'phone' => null,
    'phoneLink' => null,
    'email' => null,
    'id' => 'mobile-menu',
    'openLabel' => 'Открыть меню',
    'closeLabel' => 'Закрыть меню',
    'align' => 'right',
])

@php
    $alignClass = $align === 'left' ? 'mm-menu--left' : 'mm-menu--right';
    $hasDefaultSlot = $slot->isNotEmpty();
    $hasHeader = isset($header) && trim((string) $header) !== '';
    $hasContacts = isset($contacts) && trim((string) $contacts) !== '';
    $hasFooter = isset($footer) && trim((string) $footer) !== '';
@endphp

<button
    type="button"
    class="mm-burger"
    aria-label="{{ $openLabel }}"
    aria-expanded="false"
    aria-controls="{{ $id }}"
    data-mm-toggle
>
    <svg class="mm-burger__icon mm-burger__icon--menu" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <svg class="mm-burger__icon mm-burger__icon--close" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
</button>

<div class="mm-overlay" data-mm-overlay aria-hidden="true"></div>

<aside class="mm-menu {{ $alignClass }}" id="{{ $id }}" data-mm-menu aria-hidden="true">
    <div class="mm-menu__inner">
        @if ($hasDefaultSlot)
            {{-- Full override via default slot --}}
            {{ $slot }}
        @else
            {{-- Header: custom slot OR auto-rendered nav list --}}
            @if ($hasHeader)
                <div class="mm-menu__section mm-menu__section--header">
                    {{ $header }}
                </div>
            @elseif (count($items))
                <nav aria-label="Мобильная навигация">
                    <ul class="mm-menu__list">
                        @foreach ($items as $item)
                            <li>
                                <a href="{{ $item['url'] ?? '#' }}" class="mm-menu__link">
                                    {{ $item['label'] ?? '' }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif

            {{-- Contacts: custom slot OR auto-rendered phone/email --}}
            @if ($hasContacts)
                <div class="mm-menu__section mm-menu__section--contacts">
                    {{ $contacts }}
                </div>
            @elseif ($phone || $email)
                <div class="mm-menu__contacts">
                    @if ($phone)
                        <a href="tel:{{ $phoneLink ?? $phone }}" class="mm-menu__contact mm-menu__contact--phone">
                            {{ $phone }}
                        </a>
                    @endif
                    @if ($email)
                        <a href="mailto:{{ $email }}" class="mm-menu__contact mm-menu__contact--email">
                            {{ $email }}
                        </a>
                    @endif
                </div>
            @endif

            {{-- Footer: custom slot only (no default) --}}
            @if ($hasFooter)
                <div class="mm-menu__section mm-menu__section--footer">
                    {{ $footer }}
                </div>
            @endif
        @endif
    </div>
</aside>