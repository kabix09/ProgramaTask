<?php

namespace App\Domain\Task;

use App\Domain\Task\Status\DoneStatusStrategy;
use App\Domain\Task\Status\InProgressStatusStrategy;
use App\Domain\Task\Status\StatusValidationStrategyInterface;

enum TaskStatus: string
{
    case TODO = 'TO_DO';
    case DONE = 'DONE';
    case IN_PROGRESS = 'IN_PROGRESS';

    public function getValidationStrategy(): ?StatusValidationStrategyInterface
    {
        return match ($this) {
            self::IN_PROGRESS => new InProgressStatusStrategy(),
            self::DONE => new DoneStatusStrategy(),
            default => null,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::TODO => 'Do zrobienia',
            self::DONE => 'Zakończone',
            self::IN_PROGRESS => 'W toku',
        };
    }
}
