<?php
declare(strict_types = 1);

namespace bgw\batch05;

class EventCollection extends Collection
{
    public function targetClass(): string
    {
        return Event::class;
    }
}
