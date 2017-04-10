<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 12.57
 */

namespace bgw\Mapper;


use bgw\DbFactoryMysql;
use bgw\Domain;
use bgw\IdentityObject;
use bgw\IdentityObjectMysql;
use bgw\Mapper;
use bgw\SelectionFactoryMysql;

class Mysql extends Mapper
{

    /**
     * id of a client database
     *
     * @var int
     */
    protected $clientId = null;

    /**
     * table name mapper is mapping to
     *
     * @var string
     */
    protected $_tablename = null;

    /**
     * table's primary key field name
     *
     * @var string
     */
    protected $_primary_key_field = 'id';

    /**
     *
     * @var \Zend_Db_Adapter_Abstract
     */
    protected $_connection;

    /**
     *
     * @var \Zend_Db_Select
     * @var unknown_type
     */
    protected $_select = null;

    public function __construct($table = '')
    {
        $this->_tablename = $table;
        parent::__construct();
    }

    /**
     *
     * @return Zend_Db_Adapter_Abstract
     */
    protected function _db($config)
    {
        if (empty($config)) {
            throw new Exception('no mysql db config');
        }

        $dbFactory = new DbFactoryMysql();

        return $dbFactory->setHost($config->host)
            ->setPort($config->port)
            ->setUsername($config->username)
            ->setPassword($config->password)
            ->setDbname($config->dbname)
            ->getConnection();
    }

    /**
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    public function _dbGeneral()
    {
        return $this->_db($this->_dbConfiguration->mysql->general);
    }

    /**
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    public function _dbClient()
    {
        return $this->_db($this->_dbConfiguration->mysql->client);
    }

    public function _dbClientRequest()
    {
        return $this->_db($this->_dbConfiguration->mysql->recoveryRequest->client);
    }

    /**
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    public function _dbClientData($clientId)
    {
        if (empty($clientId)) {
            throw new Exception('no client id');
        }

        $client = 'client' . $clientId;

        return $this->_db($this->_dbConfiguration->mysql->clientData->$client);
    }

    /**
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    public function _dbClientPd($clientId)
    {
        if (empty($clientId)) {
            throw new Exception('no client id');
        }

        $client = 'client' . $clientId;

        return $this->_db($this->_dbConfiguration->mysql->clientPd->$client);
    }

    public function getIdentity()
    {
        return new IdentityObjectMysql();
    }

    public function getNumRows()
    {
        if (! $this->_select)
            return 0;
        $paginator = Zend_Paginator::factory($this->_select, 'DbSelect');
        return $paginator->getTotalItemCount();
    }

    public function getLastSelect()
    {
        return $this->_select;
    }

    public function insert($obj)
    {
        if ($obj instanceof Domain) {
            if ($obj->getClientIdUnsetFromData()) {
                $obj->unsetField($obj->getClientIdKey());
            }
            $data = $obj->getData();
        } elseif (is_array($obj)) {
            $data = $obj;
        } else {
            throw new Exception("Unsupported datatype used in insert", - 1001);
        }

        return $this->_connection->insert($this->_tablename, $data);
    }

    public function lastInsertId()
    {
        return $this->_connection->lastInsertId();
    }

    public function startTransaction()
    {
        return $this->_connection->beginTransaction();
    }

    public function select(IdentityObject $identity)
    {
        $select = $this->_connection->select();
        $select->from($this->_tablename);
        $select->where($this->_getSelection()
            ->where($identity))
            ->limit($this->_getSelection()
                ->limit($identity), $this->_getSelection()
                ->offset($identity))
            ->order($this->_getSelection()
                ->orderBy($identity));
        $this->_select = $select;
        // echo $this->_select, "\n\n";
        // die;
        return $this;
    }

    /**
     *
     * @param My_Model_Domain|array $obj
     * @throws Exception
     * @return number
     */
    public function update($obj)
    {
        if ($obj instanceof Domain) {
            if ($obj->getClientIdUnsetFromData()) {
                $obj->unsetField($obj->getClientIdKey());
            }
            $bind = $obj->getData();
        } elseif (is_array($obj)) {
            $bind = $obj;
        } else {
            throw new Exception("Unsupported datatype used in insert/update", - 1001);
        }

        $db = $this->_connection;

        return $this->_connection->update($this->_tablename, $bind, $db->quoteInto("$this->_primary_key_field = (?)", $obj->{"get" . $this->_primary_key_field}()));
    }

    public function updateAll(IdentityObject $identity, array $data)
    {
        if (empty($data)) {
            throw new Exception("Data can not be empty");
        }
        return $this->_connection->update($this->_tablename, $data, $this->_getSelection()
            ->where($identity));
    }

    public function query($sql, $bind = array())
    {
        $this->_connection->query($sql, $bind);
    }

    public function rollback()
    {
        $this->_connection->rollback();
    }

    public function commit()
    {
        $this->_connection->commit();
    }

    public function delete($obj)
    {
        $db = $this->_connection;
        return $this->_connection->delete($this->_tablename, $db->quoteInto("$this->_primary_key_field = (?)", $obj->{"get" . $this->_primary_key_field}()));
    }

    public function deleteAll(IdentityObject $identity)
    {
        return $this->_connection->delete($this->_tablename, $this->_getSelection()
            ->where($identity));
    }

    protected function _getSelection():SelectionFactoryMysql
    {
        return new SelectionFactoryMysql();
    }

    protected function _selectAll(IdentityObject $identity)
    {
        $this->select($identity);
        $data = $this->_connection->fetchAll($this->_select);
        return $data;
    }

    protected function _selectOne(IdentityObject $identity)
    {
        $this->select($identity);
        $data = $this->_connection->fetchRow($this->_select);
        return $data;
    }

}