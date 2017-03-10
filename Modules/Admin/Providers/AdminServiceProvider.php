<?php

namespace Modules\Admin\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Http\Middleware\AdminMiddleware;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;


class AdminServiceProvider extends ServiceProvider
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

        $router->aliasMiddleware('admin', AdminMiddleware::class);

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(trans('admin::admin.main_nav'));
            $event->menu->add([
                'text'      => trans('admin::admin.dashboard'),
                'url'       => 'admin/',
                'active'    => ['admin/'],
                'icon'      => 'tachometer'
            ]);
            $event->menu->add(trans('admin::admin.users_and_roles'));
            $event->menu->add([
                'text' => trans('admin::users.users'),
                'url' => '#',
                'icon' => 'user',
                'can'       => 'users.read',
                'submenu' => [
                    [
                        'text'      => trans('admin::admin.show'),
                        'url'       => 'admin/users',
                        'active'    => ['admin/users'],
                        'icon'      => 'bars',
                        'can'       => 'users.read',
                    ]
                ]
            ]);

            $event->menu->add([
                'text' => trans('admin::roles.roles'),
                'url' => '#',
                'icon' => 'users',
                'can'       => 'roles.read',
                'submenu' => [
                [
                    'text'      => trans('admin::admin.show'),
                    'url'       => 'admin/roles',
                    'active'    => ['admin/roles'],
                    'icon'      => 'bars',
                    'can'       => 'roles.read',
                ]
            ]
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
            __DIR__.'/../Config/config.php' => config_path('admin.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'admin'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/admin');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admin';
        }, \Config::get('view.paths')), [$sourcePath]), 'admin');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/admin');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admin');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'admin');
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
