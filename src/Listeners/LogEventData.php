<?php

namespace Heshamfouda\PackagesManager\Listeners;

use Heshamfouda\PackagesManager\Events\ManagerEvent;
use Illuminate\Support\Facades\Log;

class LogEventData
{
    /**
     * Handle the event.
     *
     * @param ManagerEvent $event
     * @return void
     */
    public function handle(ManagerEvent $event)
    {
        if (config('packages-manager.events.logEvents')) {
            Log::{$event->envelop['type']}($event->envelop['message'], $event->envelop['data']);
        }
    }
}
