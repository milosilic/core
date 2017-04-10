<?php
/**
 * Created by PhpStorm.
 * User: ila
 * Date: 6.4.17.
 * Time: 12.49
 */

namespace bgw;


class Collection implements \Iterator
{
    protected $_factoryDomain;

    protected $_raw = array();

    protected $_total = 0;

    private $_objects = array();

    private $_pointer = 0;

    private $_result;

    private $_keyMap = array();

    protected $_commonData = array();

    public function __construct(array $raw = null, FactoryDomain $factoryDomain = null)
    {
        if (! is_null($raw) && ! is_null($factoryDomain)) {
            $this->_raw = $raw;
            $this->_total = count($raw);

            $this->_keyMap = array_keys($raw);
        }

        $this->_factoryDomain = $factoryDomain;
    }

    public function getRawData()
    {
        return $this->_raw;
    }

    public function getTotal()
    {
        return $this->_total;
    }

    public function current()
    {
        return $this->_getRow($this->_pointer);
    }

    public function key()
    {
        return $this->_pointer;
    }

    public function next()
    {
        $row = $this->_getRow($this->_pointer);

        if (! empty($row)) {
            $this->_pointer ++;
        }

        return $row;
    }

    public function rewind()
    {
        $this->_pointer = 0;

        return $this;
    }

    public function valid()
    {
        return ! is_null($this->current());
    }

    private function _getRow($num)
    {
        if ($num >= $this->_total || $num < 0) {
            return null;
        }

        if (isset($this->_objects[$num])) {
            return $this->_objects[$num];
        }

        if ($this->_raw[$this->_keyMap[$num]] instanceof Domain) {

            return $this->_raw[$this->_keyMap[$num]];
        }

        if (isset($this->_raw[$this->_keyMap[$num]])) {

            $this->__setObjectCommonData($num);

            $this->_objects[$num] = $this->_factoryDomain->createObject($this->_raw[$this->_keyMap[$num]]);
            return $this->_objects[$num];
        }

        return null;
    }

    private function __setObjectCommonData($num)
    {
        if (! empty($this->_commonData)) {

            foreach ($this->_commonData as $key => $value) {

                $this->_raw[$this->_keyMap[$num]][$key] = $value;
            }
        }
    }

    public function setCommonData($key, $value)
    {
        $this->_commonData[$key] = $value;
    }

    public function getCommonData($key)
    {
        if (isset($this->_commonData[$key])) {

            return $this->_commonData[$key];
        } else {

            return null;
        }
    }

    public function unsetCommonData($key)
    {
        if (isset($this->_commonData[$key])) {

            unset($this->_commonData[$key]);
        }
    }

    /**
     * converts result in Map key with id, value with domain
     */
    public function getMap()
    {
        $map = null;
        if ($this->getTotal() > 0) {
            $this->rewind();
            $map = array();
            while ($this->valid()) {
                $domain = $this->next();
                $map[$domain->getId()] = $domain;
            }
            $this->rewind();
        }
        return $map;
    }

}