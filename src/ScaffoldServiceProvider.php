<?php

namespace Encore\Admin\Scaffold;

use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'scaffold');

        Scaffold::boot();
    }
}