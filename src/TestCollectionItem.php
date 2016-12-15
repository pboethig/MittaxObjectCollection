<?php
/**
 * Created by PhpStorm.
 * User: pboethig
 * Date: 15.12.16
 * Time: 22:44
 */

namespace Mittax\ObjectCollection;


class TestCollectionItem
{
    /**
     * @var string
     */
    private $_property;

    /**
     * @var string
     */
    private $_property2;

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->_property;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->_property = $property;
    }

    /**
     * @return string
     */
    public function getProperty2()
    {
        return $this->_property2;
    }

    /**
     * @param string $property2
     */
    public function setProperty2($property2)
    {
        $this->_property2 = $property2;
    }
}