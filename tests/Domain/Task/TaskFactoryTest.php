<?php

declare(strict_types=1);

namespace App\Tests\Domain\Task;

use App\Domain\Task\Event\TaskCreatedEvent;
use App\Domain\Task\Task;
use App\Domain\Task\TaskFactory;
use App\Domain\Task\TaskStatus;
use PHPUnit\Framework\TestCase;

class TaskFactoryTest extends TestCase
{
    private TaskFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new TaskFactory();
    }

    public function testShouldCreateTaskSuccessfully(): void
    {
        $task = $this->factory->create("Test Title", "Test Description");

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals("Test Title", $task->getTitle());
    }

    public function testShouldThrowExceptionWhenTitleIsEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->create("", "Description");
    }

    public function testShouldCreateTaskCorrectly(): void
    {
        $factory = new TaskFactory();
        $task = $factory->create("Tytuł", "Opis");

        $this->assertInstanceOf(Task::class, $task);

        $this->assertCount(1, $task->pullEvents());
    }

    public function testShouldCreateTaskWithCorrectStatusAndEvent(): void
    {
        $task = $this->factory->create("New Task", "Description");

        $this->assertEquals(TaskStatus::TODO, $task->getStatus());

        $events = $task->pullEvents();
        $event = $events[0];

        $this->assertInstanceOf(TaskCreatedEvent::class, $event);
        $this->assertEquals("New Task", $event->getPayload()['title']);
    }
}
