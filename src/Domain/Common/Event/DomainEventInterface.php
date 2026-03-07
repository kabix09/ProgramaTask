<?php

declare(strict_types=1);

namespace App\Domain\Common\Event;

interface DomainEventInterface
{
    public function getAggregateId(): string;
    public function getOccurredAt(): \DateTimeImmutable;
    public function getPayload(): array;
}
