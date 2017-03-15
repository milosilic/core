<?php
declare(strict_types = 1);

namespace bgw\batch04;

class VenueCollection extends Collection
{
    public function targetClass()
    {
        return Venue::class;
    }
}
