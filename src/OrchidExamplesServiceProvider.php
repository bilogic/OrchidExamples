<?php

namespace Bilogic\OrchidExamples;

use Bilogic\OrchidExamples\Orchid\Screens\DOMUpdateScreen;
use Bilogic\OrchidExamples\Orchid\Screens\EmailSenderScreen;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\OrchidServiceProvider;
use Tabuna\Breadcrumbs\Trail;

class OrchidExamplesServiceProvider extends OrchidServiceProvider
{
    /**
     * Called by OrchidServiceProvider's boot() to register
     * entries in the left side Main Menu.
     *
     * @return void
     */
    public function registerMainMenu(): array
    {
        return [
            ItemMenu::label('label() with badge()')
                ->title('Orchid Examples - title()')
                ->icon('monitor')
                ->badge(function () {
                    return 1;
                }),

            ItemMenu::label('1. Send email')
                ->route('platform.example.email')
                ->icon('monitor'),

            ItemMenu::label('2. DOM Update')
                ->route('platform.example.domupdate')
                ->icon('monitor'),
        ];
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bilogic');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bilogic');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->middleware(config('platform.middleware.private'))
            ->group(function () {

                Route::screen('email', EmailSenderScreen::class)
                    ->name('platform.example.email')
                    ->breadcrumbs(function (Trail $trail) {
                        return $trail
                            ->parent('platform.index')
                            ->push('Email sender');
                    });

                Route::screen('domupdate', DOMUpdateScreen::class)
                    ->name('platform.example.domupdate')
                    ->breadcrumbs(function (Trail $trail) {
                        return $trail
                            ->parent('platform.index')
                            ->push('DOM Update');
                    });

            });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/orchidexamples.php', 'orchidexamples');

        // Register the service the package provides.
        $this->app->singleton('orchidexamples', function ($app) {
            return new OrchidExamples;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['orchidexamples'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/orchidexamples.php' => config_path('orchidexamples.php'),
        ], 'orchidexamples.config');

        // Publishing the views.
        /*$this->publishes([
        __DIR__.'/../resources/views' => base_path('resources/views/vendor/bilogic'),
        ], 'orchidexamples.views');*/

        // Publishing assets.
        /*$this->publishes([
        __DIR__.'/../resources/assets' => public_path('vendor/bilogic'),
        ], 'orchidexamples.views');*/

        // Publishing the translation files.
        /*$this->publishes([
        __DIR__.'/../resources/lang' => resource_path('lang/vendor/bilogic'),
        ], 'orchidexamples.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
