<?php

namespace App\Domain\Task;

enum TaskStatus: string
{
    case TODO = 'TO_DO';
    case DONE = 'DONE';
    case IN_PROGRESS = 'IN_PROGRESS';

    public function label(): string
    {
        return match($this) {
            self::TODO => 'Do zrobienia',
            self::DONE => 'Zakończone',
            self::IN_PROGRESS => 'W toku',
        };
    }
}
