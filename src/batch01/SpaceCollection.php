<?php
declare(strict_types = 1);

namespace bgw\batch01;

class SpaceCollection extends Collection
{
    public function targetClass(): string
    {
        return Space::class;
    }
}
