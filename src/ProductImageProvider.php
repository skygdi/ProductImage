<?php

namespace skygdi\ProductImage;


use Illuminate\Support\ServiceProvider;

class ProductImageProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include __DIR__.'/routes.php';

        //$this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        ///*
        $this->publishes([
            __DIR__.'/../database/migrations/create_product_image_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_product_image_table.php'),
        ], 'migrations');
        //*/

        /*
        $this->loadViewsFrom(__DIR__.'/views', 'paypal');

        $this->publishes([
            __DIR__.'/views/paypal_button.blade.php' => base_path('resources/views/vendor/skygdi/paypal_button.blade.php'),
        ]);
        */
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // register our controller
        $this->app->make('skygdi\paypal\CommonController');
        
    }
}
