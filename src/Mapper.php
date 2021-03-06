<?php
declare(strict_types = 1);


/**
 * Created by PhpStorm.
 * User: ila
 * Date: 10.3.17.
 * Time: 16.47
 */
abstract class Mapper
{
    protected $pdo = null;

    public function __construct()
    {
        $reg = Registry::instance();
        $this->pdo = $reg->getPdo();
    }

    private function getFromMap($id)
    {
        return ObjectWatcher::exists(
            $this->targetClass(),
            $id
        );
    }

    private function addToMap(DomainObject $obj): DomainObject
    {
        return ObjectWatcher::add($obj);
    }

    public function find(int $id)
    {
        $old = $this->getFromMap($id);

        if ($old) {
            return $old;
        }

        $this->selectstmt()->execute([$id]);
        $raw = $this->selectstmt()->fetch();
        $this->selectstmt()->closeCursor();

        if (! is_array($raw)) {
            return null;
        }

        if (! isset($raw['id'])) {
            return null;
        }

        $object = $this->createObject($raw);
        $object->markClean();

        return $object;
    }

    public function findAll(): Collection
    {
        $this->selectAllStmt()->execute([]);

        return $this->getCollection($this->selectAllStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function getFactory(): PersistenceFactory
    {
        return PersistenceFactory::getFactory($this->targetClass());
    }

    public function createObject(array $row): DomainObject
    {
        $objfactory = $this->getFactory()->getDomainObjectFactory();

        return $objfactory->createObject($row);
    }

    public function getCollection(array $raw): Collection
    {
        return $this->getFactory()->getCollection($raw);
    }

    public function insert(DomainObject $obj)
    {
        $this->doInsert($obj);
        $this->addToMap($obj);
        $obj->markClean();
    }

//  abstract function update( DomainObject $object );
    abstract protected function doInsert(DomainObject $object);
    abstract protected function targetClass(): string;
    abstract protected function selectStmt(): \PDOStatement;
    abstract protected function selectAllStmt(): \PDOStatement;
}
