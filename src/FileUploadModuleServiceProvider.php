<?php

/*
 * This file is part of the Stock Module package.
 *
 * (c) Khoerul Umam <id.khoerulumam@gmail.com>
 *
 */

namespace BarraDev\FileUploadModule;

use Illuminate\Support\ServiceProvider;
use BarraDev\FileUploadModule\FileUploadModulePublishCommand;

/**
 * Stock Module Service Provider
 */
class FileUploadModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FileUploadModulePublishCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
