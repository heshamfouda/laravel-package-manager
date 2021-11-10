<?php

namespace Heshamfouda\PackagesManager\Listeners;

use DebugBar\DataCollector\MessagesCollector;
use Heshamfouda\PackagesManager\Events\ManagerEvent;
use Illuminate\Contracts\Container\BindingResolutionException;

class SendEventDataToDebugBar
{
    /**
     * @var MessagesCollector
     */
    protected $collector;

    /**
     * @throws BindingResolutionException
     */
    public function __construct($collector = null)
    {
        if ($collector && $this->debugBarLoaded()) {
            app()->make('debugbar')->addCollector($this->collector = $collector);
        }
    }

    /**
     * check if debug bar loaded
     *
     * @return bool
     */
    private function debugBarLoaded(): bool
    {
        return app()->environment('local') && class_exists(MessagesCollector::class);
    }

    /**
     * Handle the event.
     *
     * @param ManagerEvent $event
     * @return void
     */
    public function handle(ManagerEvent $event)
    {
        if (! $this->debugBarLoaded()) {
            return;
        }

        // todo: $event->envelop['data'] is not working here
        $this->collector->{$event->envelop['type']}($event->envelop['message']);
    }
}
