<?php

declare(strict_types=1);

namespace App\Domain\User\Event;

use App\Domain\Common\Event\DomainEventInterface;

class UserCreatedEvent implements DomainEventInterface
{
    private string $userId;
    private string $email;
    private \DateTimeImmutable $occurredAt;

    public function __construct(string $userId, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->occurredAt = new \DateTimeImmutable();
    }

    public function getAggregateId(): string
    {
        return $this->userId;
    }

    public function getPayload(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    public function getOccurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
