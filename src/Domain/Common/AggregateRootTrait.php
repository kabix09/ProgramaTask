<?php

declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Common\Event\DomainEventInterface;

trait AggregateRootTrait
{
    /** @var DomainEventInterface[] */
    private array $recordedEvents = [];

    protected function recordEvent(DomainEventInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @return array<int, DomainEventInterface>
     */
    public function pullEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }
}
