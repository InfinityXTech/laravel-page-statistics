<?php

namespace InfinityXTech\PageStatistics;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PageStatisticsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-page-statistics')
            ->hasConfigFile()
            ->hasMigration('create_page_statistics_tables');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        app()->bind(
            \CyrildeWit\EloquentViewable\Contracts\Views::class,
            \InfinityXTech\PageStatistics\Models\Views::class
        );
    }
}
