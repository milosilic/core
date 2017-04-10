<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 15.21
 */

namespace bgw;


class IdentityObjectMysql extends IdentityObject
{
    // add an equality operator to the current field
    // ie 'age' becomes age=40
    // returns a reference to the current object (via operator())
    public function eq($value):IdentityObjectMysql
    {
        return $this->_operator("=", $value);
    }

    // add an equality operator to the current field
    // ie 'age' becomes age=40
    // returns a reference to the current object (via operator())
    public function eqBin($value):IdentityObjectMysql
    {
        return $this->_operator("= BINARY", $value);
    }

    public function isNull():IdentityObjectMysql
    {
        return $this->_operator("IS NULL");
    }

    public function isNotNull():IdentityObjectMysql
    {
        return $this->_operator("IS NOT NULL");
    }

    public function ne($value):IdentityObjectMysql
    {
        return $this->_operator("<>", $value);
    }

    // less than
    public function lt($value):IdentityObjectMysql
    {
        return $this->_operator("<", $value);
    }

    // less than or equal
    public function le($value):IdentityObjectMysql
    {
        return $this->_operator("<=", $value);
    }

    // greater than
    public function gt($value):IdentityObjectMysql
    {
        return $this->_operator(">", $value);
    }

    // greater than or equal
    public function ge($value):IdentityObjectMysql
    {
        return $this->_operator(">=", $value);
    }

    // IN list
    public function in($value):IdentityObjectMysql
    {
        return $this->_operator('IN', '(\'' . join('\',\'', $value) . '\')');
    }

    public function nin($value):IdentityObject
    {
        return $this->_operator("NOT IN", '(\'' . join('\',\'', $value) . '\')');
    }
}