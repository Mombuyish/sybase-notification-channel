<?php

namespace Yish\Notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client as HttpClient;
use Yish\Notifications\Channels\SybaseChannel;
use Illuminate\Notifications\ChannelManager;


class SybaseChannelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Notification::extend('sybase', function ($app) {
            return new SybaseChannel(
                new HttpClient,
                $this->app['config']['services.sybase']
            );
        });

    }
}
