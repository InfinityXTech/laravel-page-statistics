<?php

namespace InfinityXTech\PageStatistics\Commands;

use Illuminate\Console\Command;

class PageStatisticsCommand extends Command
{
    public $signature = 'laravel-page-statistics';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
