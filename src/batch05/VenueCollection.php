<?php
declare(strict_types = 1);

namespace bgw\batch05;

class VenueCollection extends Collection
{
    public function targetClass(): string
    {
        return Venue::class;
    }
}
