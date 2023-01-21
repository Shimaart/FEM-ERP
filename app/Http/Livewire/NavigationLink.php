<?php

namespace App\Http\Livewire;

class NavigationLink
{
    public string $label;
    public ?string $url = null;
    public bool $active = false;
    public bool $visible = true;
    public array $items = [];
    public ?string $badge = null;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label): self
    {
        return new static($label);
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function active(bool $active = true): self
    {
        $this->active = $active;
        return $this;
    }

    public function visible(bool $visible = true): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function resource(string $resource): self
    {
        $this->url = route($resource . '.index');
        $this->active = request()->routeIs($resource . '*');
        return $this;
    }

    public function items(array $items): self
    {
        $this->items = $items;
        $this->active = collect($this->items)->contains(fn (NavigationLink $link) => $link->active === true);
        return $this;
    }

    public function badge(?string $badge = null): self
    {
        $this->badge = $badge;
        return $this;
    }
}
