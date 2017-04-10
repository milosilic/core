<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 15.45
 */

namespace bgw;


abstract class FactoryDomain
{
    abstract public function createObject(array $data):Domain;
}