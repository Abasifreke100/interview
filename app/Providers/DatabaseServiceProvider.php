<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = base_path('modules');
        $this->loadMigrationsFrom([
            $path.'/Auth/Migrations',
            $path.'/Loan/Migrations',
            $path . '/Project/Migrations',
        ]);
    }
}
