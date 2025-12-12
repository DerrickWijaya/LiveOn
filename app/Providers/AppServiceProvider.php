<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Helper function for image URLs
        \Blade::directive('imageUrl', function ($expression) {
            return "<?php echo (str_starts_with($expression, 'http://') || str_starts_with($expression, 'https://')) ? $expression : asset('storage/' . $expression); ?>";
        });
    }
}
