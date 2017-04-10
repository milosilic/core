<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 13.56
 */

namespace bgw;


class DbFactoryMysql extends  DbFactory
{

    public function getConnection()
    {
        // get mysql connection
        $db = Db::factory('Pdo_Mysql', array(
                'host' => $this->getHost(),
                'port' => $this->getPort(),
                'username' => $this->getUsername(),
                'password' => $this->getPassword(),
                'dbname' => $this->getDbname(),
                'driver_options' => array(
                    \PDO::MYSQL_ATTR_LOCAL_INFILE => true
                )
            )
        );

        try {
            // test mysql connection
            $db->getConnection();
        } catch (Zend_Exception $e) {
            // var_dump($e);
            // throw new Exception("Database connection not present", 1036);
            // TODO: uraditi nesto sa exceptionom
        }

        return $db;
    }

}