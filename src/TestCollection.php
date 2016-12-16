<?php
/**
 * Created by PhpStorm.
 * User: pboethig
 * Date: 15.12.16
 * Time: 22:52
 */

namespace Mittax\ObjectCollection;


class TestCollection extends CollectionAbstract
{
    /**
     * TestCollection constructor.
     * @param TestCollectionItem[] $items
     */
    public function __construct(Array $items)
    {
        parent::__construct($items);
    }

    /**
     * @return ICollectionItem
     */
    public function getFirstItem() : ICollectionItem
    {
        return parent::getFirstItem();
    }

    /**
     * @return ICollection
     */
    public function getAllItems() : Array
    {
        return parent::getAllItems();
    }

    /**
     * @param string $propertyName
     * @param $value
     * @return TestCollectionItem[]
     */
    public function filter(string $propertyName, $value)
    {
        return parent::filterByPropertyNameAndValue($propertyName, $value);
    }
}