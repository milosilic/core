<?php
declare(strict_types = 1);

namespace bgw\batch07;

use bgw\batch05\VenueCollection;
use bgw\batch05\VenueObjectFactory;
use bgw\batch05\DomainObjectFactory;
use bgw\batch05\Collection;

class VenuePersistenceFactory extends PersistenceFactory
{
    public function getMapper(): Mapper
    {
        return new VenueMapper();
    }

    public function getDomainObjectFactory(): DomainObjectFactory
    {
        return new VenueObjectFactory();
    }

    public function getCollection(array $array): Collection
    {
        return new VenueCollection($array, $this->getDomainObjectFactory());
    }

    public function getSelectionFactory(): SelectionFactory
    {
        return new VenueSelectionFactory();
    }

    public function getUpdateFactory(): UpdateFactory
    {
        return new VenueUpdateFactory();
    }

    public function getIdentityObject(): IdentityObject
    {
        return new VenueIdentityObject();
    }
}
