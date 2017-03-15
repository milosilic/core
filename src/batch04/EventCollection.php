<?php
declare(strict_types = 1);

namespace bgw\batch04;

class EventCollection extends Collection
{
    public function targetClass()
    {
        return Event::class;
    }
}
