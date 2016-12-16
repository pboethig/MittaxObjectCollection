<?php
/**
 * Created by PhpStorm.
 * User: pboethig
 * Date: 15.12.16
 * Time: 22:43
 */

namespace Mittax\ObjectCollection\Tests;

require_once __DIR__ . '/../src/ICollection.php';
require_once __DIR__ . '/../src/ICollectionItem.php';
require_once __DIR__ . '/../src/CollectionAbstract.php';
require_once __DIR__ . '/../src/TestCollectionItem.php';
require_once __DIR__ . '/../src/TestCollection.php';

use Mittax\ObjectCollection\TestCollection;
use Mittax\ObjectCollection\TestCollectionItem;

class CollectionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var TestCollectionItem[]
     */
    protected $_itemList = [];

    /**
     * @var TestCollection
     */
    protected $_typedCollection;

    public function setUp()
    {
        parent::setUp();

        $this->_createFixure();
    }

    private function _createFixure()
    {
        $testCollectionItem = new TestCollectionItem();
        $testCollectionItem->setProperty('test1');
        $testCollectionItem->setProperty2('test2');

        $testCollectionItem2 = new TestCollectionItem();
        $testCollectionItem2->setProperty('test3');
        $testCollectionItem2->setProperty2('test4');

        $this->_itemList = [$testCollectionItem, $testCollectionItem2];
        $this->_typedCollection = new TestCollection($this->_itemList);
    }

    public function testCountCollection()
    {
        $this->assertEquals(2, $this->_typedCollection->count());
    }


    public function testGetFirstItemCollection()
    {
        $this->assertEquals('test1', $this->_typedCollection->getFirstItem()->getProperty());
    }

    public function testGetAllItemsCollection()
    {
        $this->assertEquals(2, count($this->_typedCollection->getAllItems()));

    }

    public function testInstance()
    {
        $this->assertInstanceOf(TestCollection::class, $this->_typedCollection);

        $this->_typedCollection->filter('property', 'test3');

        $this->assertEquals('test3', $this->_typedCollection->getFirstItem()->getProperty());
    }

    public function testFilter()
    {
        $this->_typedCollection->filter('property', 'test3');

        $this->assertEquals('test3', $this->_typedCollection->getFirstItem()->getProperty());
    }

}