<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 10.4.17.
 * Time: 16.51
 */

namespace bgw;


class FactoryDomainLdap extends FactoryDomain
{

    public function createObject(array $data): Domain
    {

        $obj = new Domain( $data['id'] );

        unset($data['id']);

        $obj->setData($data);

        return $obj;
    }

}