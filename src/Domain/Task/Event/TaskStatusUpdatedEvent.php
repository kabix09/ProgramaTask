<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Common\Event\DomainEventInterface;

class TaskStatusUpdatedEvent implements DomainEventInterface
{
    private \DateTimeImmutable $occurredAt;

    public function __construct(
        private string $taskId,
        private string $oldStatus,
        private string $newStatus
    ) {
        $this->occurredAt = new \DateTimeImmutable();
    }

    public function getAggregateId(): string
    {
        return $this->taskId;
    }
    public function getOccurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
    public function getPayload(): array
    {
        return [
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus
        ];
    }
}
