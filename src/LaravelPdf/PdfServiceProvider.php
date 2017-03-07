<?php

namespace niklasravnsborg\LaravelPdf;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PdfServiceProvider extends BaseServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $pathImages = storage_path('framework/mpdf/images/');
        $pathFonts = storage_path('framework/mpdf/fonts/');

        if (!is_dir($pathImages))
        {
            @mkdir($pathImages, 0777);
        }

        if (!is_dir($pathFonts))
        {
            @mkdir($pathFonts, 0777);
        }

        if (!defined('_MPDF_TEMP_PATH') && is_dir($pathImages))
        {
            define('_MPDF_TEMP_PATH', $pathImages);
        }

        if (!defined('_MPDF_TTFONTDATAPATH') && is_dir($pathFonts))
        {
            define('_MPDF_TTFONTDATAPATH', $pathFonts);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/pdf.php', 'pdf'
        );

        $this->app->bind('mpdf.wrapper', function($app) {
            return new PdfWrapper();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('mpdf.pdf');
    }

}
