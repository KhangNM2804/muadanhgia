<?php

namespace Ecs\L8Core;

use Ecs\L8Core\Commands\MakeEnum;
use Illuminate\Support\ServiceProvider;
use Ecs\L8Core\Commands\MakeResponse;
use Ecs\L8Core\Commands\MakeRepository;
use Ecs\L8Core\Commands\MakeService;
use Ecs\L8Core\Commands\MakeFilter;

class L8CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepository::class,
                MakeService::class,
                MakeFilter::class,
                MakeResponse::class,
                MakeEnum::class,
            ]);
        }
    }
}
