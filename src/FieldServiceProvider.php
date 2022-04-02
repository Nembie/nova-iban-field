<?php

namespace Nembie\NovaIbanField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-iban-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-iban-field', __DIR__.'/../dist/css/field.css');
            Nova::translations(__DIR__.'/../resources/lang/'.app()->getLocale().'/messages.json');
        });
        $this->loadTranslationsFrom( __DIR__.'/../resources/lang', 'messages');
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
