<?php
declare(strict_types = 1);

namespace bgw\batch01;

abstract class DomainObject
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function markDirty()
    {
    }
}
