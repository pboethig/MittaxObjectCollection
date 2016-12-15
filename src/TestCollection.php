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
        parent::__construct();

        foreach ($items as $item)
        {
            $this->add($item);
        }
    }

    /**
     * @return TestCollectionItem
     */
    public function getFirstItem()
    {
        return parent::getFirstItem();
    }

    /**
     * @return TestCollectionItem[]
     */
    public function getAllItems()
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