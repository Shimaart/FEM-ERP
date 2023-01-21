<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::role('admin', __('Администратор'), ['*']);

        Jetstream::role('director', __('Директор'), [
            'view any orders',
            'create any orders',
            'update any orders',
            'delete any orders',
            'view any leads',
            'create any leads',
            'update any leads',
            'assign any lead manager',
            'delete any leads',
            'view any production requests',
            'view any productions',
            'create any productions',
            'update any productions',
            'process any productions',
            'receive any productions'
        ]);

        Jetstream::role('sales manager', __('Менеджер по продажам'), [
            'view any orders',
            'create any orders',
            'update any orders',
            'delete any orders',
            'view any leads',
            'create any leads',
            'manage any leads',
            'update any leads',
        ]);

        Jetstream::role('supply manager', __('Менеджер снабжения'), [
            'view any orders',
            'create any orders',
            'update any orders',
            'view any production requests',
            'view any productions',
            'create any productions',
            'update any productions',
        ]);

        Jetstream::role('production chief', __('Начальник производства'), [
            'view any productions',
            'process any productions',
        ]);

        Jetstream::role('warehouse chief', __('Начальник склада'), [
            'view any productions',
            'receive any productions'
        ]);

        Jetstream::role('accountant', __('Бухгалтер'), [

        ]);
    }
}
