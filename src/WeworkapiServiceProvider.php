<?php

namespace Elutiger\Weworkapi;

use Illuminate\Support\ServiceProvider; 

class WeworkapiServiceProvider extends ServiceProvider
{
     

   

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        include_once(__DIR__."/Libs/api/src/CorpAPI.class.php");   
         
        $this->app->singleton('CorpAPI', function ($app) {

            return  new CorpAPI(config('weworkapi.CORP_ID'), config('weworkapi.APP_SECRET'));  

        });
 
    }

    public function boot()
    {
        $this->publishes([
            __DIR__."/Libs/api/config.php" => config_path('weworkapi.php'),
        ]);

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['CorpAPI'];
    }

 

}
