<?php

declare(strict_types=1);

namespace App\Tests\Domain\Task;

use App\Domain\Task\Event\TaskStatusUpdatedEvent;
use App\Domain\Task\Task;
use App\Domain\Task\TaskStatus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class TaskTest extends TestCase
{
    public function testShouldChangeStatusAndRecordEvent(): void
    {
        $task = new Task(Uuid::v4(), "Title", "Desc");
        $task->pullEvents();

        $task->changeStatus(TaskStatus::DONE);

        $this->assertEquals(TaskStatus::DONE, $task->getStatus());

        $events = $task->pullEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(TaskStatusUpdatedEvent::class, $events[0]);

        $payload = $events[0]->getPayload();
        $this->assertEquals('TO_DO', $payload['old_status']);
        $this->assertEquals('DONE', $payload['new_status']);
    }

    public function testShouldNotRecordEventWhenStatusIsSame(): void
    {
        $task = new Task(Uuid::v4(), "Title", "Desc");
        $task->pullEvents();

        $task->changeStatus(TaskStatus::TODO);

        $this->assertCount(0, $task->pullEvents());
    }
}
