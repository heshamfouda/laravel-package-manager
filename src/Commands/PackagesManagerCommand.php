<?php

namespace Heshamfouda\PackagesManager\Commands;

use Illuminate\Console\Command;

class PackagesManagerCommand extends Command
{
    public $signature = 'manager';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
