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
    public function getFirstItem() : ICollectionItem;

    /**
     * @return ICollection
     */
    public function getAllItems() : Array;

    /**
     * @return ICollection
     */
    public function getCollection() : ICollection;

    /**
     * @return int
     */
    public function count() : int;
}