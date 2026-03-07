<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Common\Event\DomainEventInterface;
use App\Domain\Task\TaskStatus;

class TaskCreatedEvent implements DomainEventInterface
{
    private \DateTimeImmutable $occurredAt;

    public function __construct(
        private string $taskId,
        private string $title
    ) {
        $this->occurredAt = new \DateTimeImmutable();
    }

    public function getAggregateId(): string { return $this->taskId; }
    public function getOccurredAt(): \DateTimeImmutable { return $this->occurredAt; }
    public function getPayload(): array
    {
        return [
            'title' => $this->title,
            'status' => TaskStatus::TODO->value,
        ];
    }
}

