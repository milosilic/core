<?php
declare(strict_types = 1);

namespace bgw\batch05;

class SpaceCollection extends Collection
{

    public function targetClass(): string
    {
        return Space::class;
    }
}
