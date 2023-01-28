<?php declare(strict_types=1);

namespace Karvaka\Wired\Select\Components;

use Illuminate\Support\Str;
use Livewire\Component;

abstract class Select extends Component
{
    public ?string $value = null;
    public ?string $placeholder = null;
    public ?string $event = null;

    abstract public function options(): iterable;

    public function updatedValue($value): void
    {
        $this->emit($this->getEvent(), $value);
    }

    public function getEvent(): string
    {
        return $this->event ?: static::guessEventForComponent($this);
    }

    public static function guessEventForComponent($class): string
    {
        return Str::of(is_object($class) ? class_basename($class) : $class)
                ->classBasename()->replaceLast('Select', '')->singular()->camel() . 'Selected';
    }

    public function render()
    {
        return view('wired-select::select', [
            'options' => $this->options()
        ]);
    }
}
