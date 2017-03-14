<?php
declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: ila
 * Date: 10.3.17.
 * Time: 16.51
 */
abstract class DomainObjectFactory
{
    abstract public function createObject(array $row): DomainObject;

    protected function getFromMap($class, $id)
    {
        return ObjectWatcher::exists($class, $id);
    }

    protected function addToMap(DomainObject $obj): DomainObject
    {
        return ObjectWatcher::add($obj);
    }
}
