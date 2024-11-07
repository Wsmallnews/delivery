<?php

namespace Wsmallnews\Delivery\Commands;

use Illuminate\Console\Command;

class DeliveryCommand extends Command
{
    public $signature = 'delivery';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
