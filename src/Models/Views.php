<?php

namespace InfinityXTech\PageStatistics\Models;

use CyrildeWit\EloquentViewable\Views as EloquentViewableViews;
use CyrildeWit\EloquentViewable\Contracts\View as ViewContract;
use CyrildeWit\EloquentViewable\Contracts\Views as ViewsContract;
use Illuminate\Container\Container;

class Views extends EloquentViewableViews
{
    protected string $location;
    protected string $device;
    protected string $os;
    protected string $browser;
    protected array $meta = [];
    protected $casts = ['meta' => 'array'];
    /**
     * Create a new view instance.
     *
     * @return \CyrildeWit\EloquentViewable\Contracts\View
     */
    protected function createView(): ViewContract
    {
        $view = Container::getInstance()->make(ViewContract::class);

        return $view->create([
            'viewable_id' => $this->viewable->getKey(),
            'viewable_type' => $this->viewable->getMorphClass(),
            'visitor' => $this->visitor->id(),
            'collection' => $this->collection,
            'location' => $this->location,
            'device' => $this->device,
            'os' => $this->os,
            'browser' => $this->browser,
            'meta' => json_encode($this->meta),
            'viewed_at' => now(),
        ]);
    }

    /**
     * Set the collection.
     */
    public function location(string $location): ViewsContract
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Set the collection.
     */
    public function device(string $device): ViewsContract
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Set the collection.
     */
    public function os(string $os): ViewsContract
    {
        $this->os = $os;

        return $this;
    }

    /**
     * Set the collection.
     */
    public function browser(string $browser): ViewsContract
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Set the collection.
     */
    public function getVisitor()
    {
        return $this->visitor->id();
    }

    /**
     * Set the collection.
     */
    public function meta(array $meta): ViewsContract
    {
        $this->meta = $meta;

        return $this;
    }
}
