<?php
declare(strict_types = 1);

namespace bgw\batch05;

use bgw\batch04\ObjectWatcher;
use bgw\batch04\DomainObject;

/* listing 13.31 */
abstract class DomainObjectFactory
{
    abstract public function createObject(array $row): DomainObject;

/* /listing 13.31 */
    protected function getFromMap($class, $id)
    {
        return ObjectWatcher::exists($class, $id);
    }

    protected function addToMap(DomainObject $obj): DomainObject
    {
        return ObjectWatcher::add($obj);
    }
/* listing 13.31 */
}
/* /listing 13.31 */
