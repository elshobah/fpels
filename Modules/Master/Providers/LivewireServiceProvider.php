<?php

namespace Modules\Master\Providers;

use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \Livewire\Livewire::component('student-form', \Modules\Master\Http\Livewire\Student\Form::class);
    }
}
