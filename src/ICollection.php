<?php
/**
 * Created by PhpStorm.
 * User: pboethig
 * Date: 16.12.16
 * Time: 01:36
 */

namespace Mittax\ObjectCollection;


interface ICollection
{
    /**
     * @return ICollectionItem
     */
    public function getFirstItem();

    /**
     * @return ICollectionItem[]
     */
    public function getAllItems();

    /**
     * @return ICollection
     */
    public function getCollection();

    /**
     * @return int
     */
    public function count();
}