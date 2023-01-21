<?php

namespace App\Concerns;

trait LocaleAware
{
    public function applicationLocales(): array
    {
        return array_keys($this->applicationLanguages());
    }

    public function applicationLanguages(): array
    {
        return [
            'ru' => 'Русский',
            'uk' => 'Українська',
        ];
    }
}
