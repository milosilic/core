<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 10.4.17.
 * Time: 15.16
 */

namespace bgw\Mapper;

use bgw\DbFactoryLdap;
use bgw\Mapper;

class Ldap extends Mapper{
    /**
     *
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_connection;

    protected function _db( $config )
    {
        if( empty($config) ) {
            //throw new Exception('no ldap db config');
        }
        $dbFactory = new DbFactoryLdap();

        return  $dbFactory->getConnection();

    }

    /**
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function _dbGeneral()
    {
        return $this->_db($this->_dbConfiguration->mysql->general);
    }

    public function getIdentity()
    {
        return new \IdentityObjectLdap();
    }



    protected function _selectAll( \IdentityObjectLdap $identity ) {

        $read = ldap_search($this->_db(null), "ou=Users,dc=bitgear,dc=rs",'(&(gidnumber=513))')  or exit("Unable to search LDAP server, response was: " . ldap_error($this->_db(null)));
        $info = ldap_get_entries($this->_db(null), $read);

        $returnArray = array();
        $j = 0;
        // Loop over
        for ($i=0; $i < $info['count']; $i++) {
            $returnArray[$j]['name'] = $info[$i]['uid'][0];
            $returnArray[$j]['uidnumber'] = $info[$i]['uidnumber'][0];
            $returnArray[$j]['gidnumber'] = $info[$i]['gidnumber'][0];
            $returnArray[$j]['displayname'] = isset($info[$i]['displayname'][0])?$info[$i]['displayname'][0]:null;
            $j++;
        }
        return $returnArray;

    }



}