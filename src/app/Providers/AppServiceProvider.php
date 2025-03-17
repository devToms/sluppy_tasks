<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Client\PetstoreClient;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->bind(PetstoreClient::class, function ($app) {
        //     return new PetstoreClient(); // Możesz przekazać konfigurację lub inne zależności
        // });
    }
}