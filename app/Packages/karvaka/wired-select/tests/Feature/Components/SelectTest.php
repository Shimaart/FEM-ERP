<?php declare(strict_types=1);

namespace Tests\Feature\Components;

use Livewire\Livewire;
use Tests\Fixtures\DrinksSelect;
use Tests\TestCase;

class SelectTest extends TestCase
{
    public function testCanEmitEventOnValueChanged(): void
    {
        $component = Livewire::test(DrinksSelect::class);

        $component->assertSet('value', null);
        $component->set('value', 'Beer');
        $component->assertEmitted('drinkSelected', 'Beer');
    }
}
