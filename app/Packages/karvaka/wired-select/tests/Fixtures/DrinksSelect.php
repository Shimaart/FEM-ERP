<?php declare(strict_types=1);

namespace Tests\Fixtures;

use Karvaka\Wired\Select\Components\Select;

class DrinksSelect extends Select
{
    public function options(): iterable
    {
        $drinks = [
            'Vodka',
            'Whiskey',
            'Brandy',
            'Vermouth',
            'Beer',
            'Rum'
        ];

        return array_combine($drinks, $drinks);
    }
}
