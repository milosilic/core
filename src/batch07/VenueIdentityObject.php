<?php
declare(strict_types = 1);

namespace bgw\batch07;

class VenueIdentityObject extends IdentityObject
{
    public function __construct(string $field = null)
    {
        parent::__construct($field, ['name', 'id']);
    }
}
