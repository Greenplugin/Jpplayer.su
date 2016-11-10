<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        if(request()->getHost() != config()->get('app.domain') && request()->decodedPath() != 'telegram-api/'.config()->get('telegram.web_hook')){
            if(strlen(request()->decodedPath()) > 1){
                redirect(config()->get('app.url').'/'.request()->decodedPath(), 301)->send();
            }
            else {
               redirect(config()->get('app.url'), 301)->send();
            }

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
