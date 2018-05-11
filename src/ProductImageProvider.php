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
        if ( !class_exists('CreateProductImageTable') ) {
            //For whole new install(migrate)
            $this->publishes([
                __DIR__.'/../database/migrations/create_product_image_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_product_image_table.php'),
            ], 'migrations');
        }
        else{
            //Add feature
            if ( !class_exists('ProductImageTableAddFeatured') ) {
                $this->publishes([
                    __DIR__.'/../database/migrations/product_image_table_add_featured.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_product_image_add_featured_table.php'),
                ], 'migrations');
            }
            
            //e
        }
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
        //$this->app->make('skygdi\paypal\CommonController');
        
    }
}
