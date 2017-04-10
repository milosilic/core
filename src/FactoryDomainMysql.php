<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 15.47
 */

namespace bgw;


class FactoryDomainMysql extends FactoryDomain
{

    public function createObject(array $data):Domain
    {
        $obj = new Domain($data['id']);

//        unset($data['id']);

        $obj->setData($data);

        return $obj;
    }
}