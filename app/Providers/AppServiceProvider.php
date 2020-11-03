<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use App\Models\Contract;
use App\Models\Property;
use App\Observers\ContractObserver;
use App\Observers\PropertyObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Contract::observe( ContractObserver::class );
        Property::observe( PropertyObserver::class );
    }
}
