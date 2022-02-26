<?php

namespace TopSystem\TopPortal;

use Illuminate\Support\ServiceProvider;
use TopSystem\TopAdmin\Facades\Admin;
use TopSystem\TopAdmin\Seed;
use TopSystem\TopPortal\Models\Category;
use TopSystem\TopPortal\Models\Page;
use TopSystem\TopPortal\Models\Post;

class PortalServiceProvider extends ServiceProvider{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerConfigs();

        $this->loadHelpers();

        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
            $this->registerConsoleCommands();
        }
        Admin::useModel("Category", Category::class);
        Admin::useModel("Page", Page::class);
        Admin::useModel("Post", Post::class);

    }

    /**
     * Register the publishable files.
     */
    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__).'/publishable';

        $publishable = [
            'dummy_seeds' => [
                "{$publishablePath}/database/seeds/" => database_path(Seed::getFolderName()),
            ],
//            'dummy_content' => [
//                "{$publishablePath}/dummy_content/" => storage_path('app/public'),
//            ],
//            'dummy_config' => [
//                "{$publishablePath}/config/admin_dummy.php" => config_path('admin.php'),
//            ],
            'dummy_migrations' => [
                "{$publishablePath}/database/migrations/" => database_path('migrations'),
            ],

        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    public function registerConfigs()
    {
//        $this->mergeConfigFrom(
//            dirname(__DIR__).'/../publishable/config/admin_dummy.php',
//            'portal'
//        );
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }


    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
    }
}