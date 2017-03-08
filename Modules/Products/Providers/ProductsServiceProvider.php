<?php

namespace Modules\Products\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class ProductsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $events)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'header' => trans('PRODUCTS & CATEGORIES'),
                'can' => 'products.read'
            ]);
            $event->menu->add([
                'text'      => trans('Products'),
                'url'       => 'admin/products/',
                'active'    => ['admin/products/'],
                'icon'      => 'building',
                'can'       => 'products.read',
            ]);

        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('products.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'products'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/products');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/products';
        }, \Config::get('view.paths')), [$sourcePath]), 'products');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/products');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'products');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'products');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
