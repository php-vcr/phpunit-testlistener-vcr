<?php

declare(strict_types=1);

namespace VCR\PHPUnit\TestListener\Subscribers;

use PHPUnit\Event;
use VCR\VCR;

class BeforeTestEnds implements Event\Test\BeforeTestMethodFinishedSubscriber
{
    /**
     * @param Event\Test\BeforeTestMethodFinished $event
     * @return void
     */
    public function notify(Event\Test\BeforeTestMethodFinished $event): void
    {
        VCR::turnOff();
    }
}
