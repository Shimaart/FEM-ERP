<?php declare(strict_types=1);

namespace Tests;

use Karvaka\Wired\Select\WiredSelectServiceProvider;
use Livewire\LivewireServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            WiredSelectServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:4QnAKQ9ykHOz4/+395vluqUNUsbYvl5hLEb4RSGTu88=');
    }
}
