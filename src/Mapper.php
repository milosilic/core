<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 10.34
 */

namespace bgw;

use \Zend_Registry;


class Mapper
{
    protected $_dbConfiguration;

    public function __construct()
    {
        $this->_dbConfiguration = Zend_Registry::get('dbConfiguration');
//        $config = __DIR__ . "/../batch01/data/woo_options.ini";
//        $options = parse_ini_file($config, true);
//        Registry::reset();
//        $reg = Registry::instance();
//        $conf = new Conf($options['config']);
//        $reg->setConf($conf);
//        $reg = Registry::instance();
//        $this->pdo = $reg->getPdo();
    }

    public function findOne(IdentityObject $identity)
    {
        // @todo napraviti get metode i proveriti da li moze u !empty ovako
        /*
         * if( !is_null($selection) && !empty($selection->getId()) ) {
         *
         * $old = $this->_getFromMap($selection->getId());
         *
         * if(!is_null($old)) {
         * return $old;
         * }
         * }
         */
        $dataArray = $this->_selectOne($identity);
        $obj = null;

        if (! empty($dataArray)) {

            $obj = $this->_factoryClassInstance()->createObject($dataArray);
        }

        return $obj;
    }

    public function findAll(IdentityObject $identity = null)
    {
        return new Collection($this->_selectAll($identity), $this->_factoryClassInstance());
    }

    protected function _addToMap(Domain $obj)
    {
        return My_Model_Watcher::add($obj);
    }

    private function _factoryClassInstance()
    {
        $factoryClass = $this->_targetClass();
        return new $factoryClass();
    }

    private function _getFromMap($id)
    {
        return My_Model_Watcher::exists($this->targetClass(), $id);
    }

    // my model mapper
    public function numberOf(IdentityObject $identity)
    {
        $dataArray = $this->_countAll($identity);
        $obj = null;

        if (! empty($dataArray)) {
            $obj = $this->_factoryClassInstance()->createObject($dataArray);
        }

        return $obj;
    }

}