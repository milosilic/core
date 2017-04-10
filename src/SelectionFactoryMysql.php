<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 14.12
 */

namespace bgw;


class SelectionFactoryMysql
{

    public function where(IdentityObject $obj)
    {
        if ($obj->isVoid()) {

            return '1';
        }

        $compstrings = array();

        foreach ($obj->getComps() as $comp) {
            if ($comp['operator'] == 'IS NULL' || $comp['operator'] == 'IS NOT NULL') {
                $compstrings[] = "{$comp['name']} {$comp['operator']}";
            } else
                if ($comp['operator'] != 'IN' && $comp['operator'] != 'NOT IN') {
                    $compstrings[] = "{$comp['name']} {$comp['operator']} '{$comp['value']}'";
                } else {
                    $compstrings[] = "{$comp['name']} {$comp['operator']} {$comp['value']}";
                }
        }

        $where = implode(" AND ", $compstrings);

        return $where;
    }

    public function orderBy(IdentityObject $obj = null)
    {
        if (is_null($obj)) {

            return array();
        }

        $result = array();

        foreach ($obj->getOrderBy() as $key => $value) {

            $result[] = $key . (strtolower($value) == 'desc' ? ' DESC' : ' ASC');
        }

        return $result;
    }

    public function limit(IdentityObject $obj = null)
    {
        if (is_null($obj)) {

            return '';
        }

        $result = $obj->getLimit();

        return $result;
    }

    public function offset(IdentityObject $obj = null)
    {
        if (is_null($obj) || $obj->isVoid()) {

            return 0;
        }

        return $obj->getOffset();
    }

    public function group(IdentityObject $obj = null)
    {
        if (is_null($obj) || $obj->isVoid()) {

            return '';
        }

        return $obj->getGroup();
    }
}