<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 10.4.17.
 * Time: 15.21
 */

namespace bgw;


class DbFactoryLdap extends DbFactory
{

    public function getConnection()
    {
        try {
            // get ldap connection
            $db =  ldap_connect("10.0.0.250");
            ldap_set_option($db, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($db, LDAP_OPT_REFERRALS, 0);

        } catch (Exception $e) {
            //echo '<pre>';
            print_r($e);//die;
        }

        return $db;
    }
}