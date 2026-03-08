<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Common\AggregateRootTrait;
use App\Domain\Task\Event\TaskCreatedEvent;
use App\Domain\Task\Event\TaskStatusUpdatedEvent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
class Task
{
    use AggregateRootTrait;

    #[ORM\Id, ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 20, enumType: TaskStatus::class)]
    private TaskStatus $status;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $userId = null;

    public function __construct(Uuid $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = TaskStatus::TODO;

        $this->recordEvent(new TaskCreatedEvent($this->id->toRfc4122(), $title));
    }

    public function changeStatus(TaskStatus $newStatus): void
    {
        if ($this->status === $newStatus) {
            return;
        }

        $oldStatus = $this->status;
        $this->status = $newStatus;

        $this->recordEvent(new TaskStatusUpdatedEvent(
            $this->id->toRfc4122(),
            $oldStatus->value,
            $newStatus->value
        ));
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getUserId(): ?Uuid
    {
        return $this->userId;
    }

    public function assignUser(Uuid $userId): void
    {
        $this->userId = $userId;
    }
}
