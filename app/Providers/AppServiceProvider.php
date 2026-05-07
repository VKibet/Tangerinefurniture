<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['components.header', 'components.footer'], function ($view): void {
            $sharedLayoutData = Cache::rememberForever('layout_shared_data', function (): array {
                return [
                    'headerCategories' => Category::active()->ordered()->get(),
                    'settings' => Setting::getAllAsArray(),
                ];
            });

            $view->with($sharedLayoutData);
        });
    }
}
