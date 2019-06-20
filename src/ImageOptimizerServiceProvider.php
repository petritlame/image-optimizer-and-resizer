<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/20/2019
 * Time: 3:54 PM
 */

namespace titi23\ImageOptimizer;

use Illuminate\Support\ServiceProvider;

/**
 * Class ImageOptimizerServiceProvider
 * @package titi23\ImageOptimizer
 */

class ImageOptimizerServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->mergeConfigFrom(__DIR__.'/config/image_config.php', 'image-optimizer');
        $this->publishes([
            __DIR__.'/config/image_config.php' => config_path('image-optimizer.php'),
        ],'image-optimizer');

    }

    public function register()
    {

    }
}
