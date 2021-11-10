<?php

namespace Heshamfouda\PackagesManager\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ManagerEvent
{
    use Dispatchable;

    /**
     * @var array
     */
    public array $envelop;

    /**
     * Create a new event instance.
     *
     * @param array $envelop
     */
    public function __construct(array $envelop)
    {
        $this->envelop = $envelop;
    }
}
