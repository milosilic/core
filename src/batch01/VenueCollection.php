<?php
declare(strict_types = 1);

namespace bgw\batch01;

/* listing 13.06 */
class VenueCollection extends Collection
{
    public function targetClass(): string
    {
        return Venue::class;
    }
}
