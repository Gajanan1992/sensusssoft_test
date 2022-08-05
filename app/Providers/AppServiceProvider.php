<?php

namespace App\Providers;

use App\Library\LoanCalculator;
use App\Library\LoanCalculatorInterface;
use Illuminate\Support\ServiceProvider;

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
        // bind loan calculator interface to loan calculator class

        $this->app->bind(LoanCalculatorInterface::class, LoanCalculator::class);
    }
}
