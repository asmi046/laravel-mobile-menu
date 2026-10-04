<?php

namespace AdvokatPotapova\MobileMenu\View\Components;

use Illuminate\View\Component;

class MobileMenu extends Component
{
    public function __construct(
        public array $items = [],
        public ?string $phone = null,
        public ?string $phoneLink = null,
        public ?string $email = null,
        public string $id = 'mobile-menu',
        public string $openLabel = 'Открыть меню',
        public string $closeLabel = 'Закрыть меню',
        public string $align = 'right',
    ) {}

    public function render()
    {
        return view('mobile-menu::mobile-menu');
    }
}
