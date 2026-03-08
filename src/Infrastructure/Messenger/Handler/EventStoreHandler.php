<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger\Handler;

use App\Domain\Common\Event\DomainEventInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\EventStoreEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'event.bus')]
class EventStoreHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DomainEventInterface $event): void
    {
        $entry = new EventStoreEntry(
            (new \ReflectionClass($event))->getShortName(),
            $event->getAggregateId(),
            $event->getPayload(),
            $event->getOccurredAt()
        );

        $this->entityManager->persist($entry);
        $this->entityManager->flush();
    }
}
