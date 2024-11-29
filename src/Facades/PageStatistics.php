<?php

namespace InfinityXTech\PageStatistics\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \InfinityXTech\PageStatistics\PageStatistics
 */
class PageStatistics extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \InfinityXTech\PageStatistics\PageStatistics::class;
    }
}
