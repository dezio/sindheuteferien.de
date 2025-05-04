<?php

namespace App\Providers;

use App\Models\SchoolHoliday;
use App\Services\HolidayService;
use App\Services\NaturalLanguageService;
use App\Services\PageService;
use App\Services\SitemapService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HolidayService::class);
        $this->app->resolving(HolidayService::class, function (HolidayService $holidayService) {
            throw_if(!SchoolHoliday::count(), new \RuntimeException("No school holidays found. Please run the command `php artisan db:seed --class=SchoolHolidaySeeder` to seed the database."));
        });
        $this->app->singleton(NaturalLanguageService::class);

        $this->configurePageService();
        $this->configureSitemap();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return void
     */
    private function configurePageService(): void
    {
        $this->app->singleton(PageService::class, function () {
            $appName = config('app.name');
            if ($appName === "Laravel") {
                $appName = "SindHeuteFerien.de"; // We're lazy ^^
            }

            $service = new \App\Services\PageService($appName);
            $service->setAuthor("SindHeuteFerien.de");
            $service->setKeywords('Ferien heute, Schulferien, Bundesländer, Deutschland, Ferienkalender, Ferienübersicht');
            return $service;
        });
    }

    private function configureSitemap(): void
    {
        $this->app->singleton(SitemapService::class);
        $this->app->resolving(SitemapService::class, function (SitemapService $sitemapService) {
            $sitemapService->registerCustomItem(route("home"));
            $sitemapService->registerCustomItem(route("impressum"));
            $sitemapService->registerCustomItem(route("datenschutz"));

            return $sitemapService;
        });
    }
}
