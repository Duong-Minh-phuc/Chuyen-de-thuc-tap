<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Components\MainMenu;
use App\View\Components\SubMainMenu;
use App\View\Components\FooterMenu;

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
        // Đăng ký các components
        $this->loadViewComponentsAs('', [
            MainMenu::class,
            SubMainMenu::class,
            FooterMenu::class,
        ]);
    }
}
