<?php

namespace InfinityXTech\PageStatistics;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use InfinityXTech\PageStatistics\Commands\PageStatisticsCommand;

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
            ->hasMigration('create_laravel_page_statistics_table')
            ->hasCommand(PageStatisticsCommand::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(
            \CyrildeWit\EloquentViewable\Contracts\Views::class,
            \App\Models\Views::class
        );
    }
}
