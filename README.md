## Simple ObjectCollection library
### Helps you build typed lists with php >=7.0

## Install
```php 
composer require mittax/objectcollection
```

## Usage

Create a subclass of objectCollectionAbstract which adds a list of objects to the collection by the constructor

Here is a sample abstraction

```php
<?php
/**
 * Created by PhpStorm.
 * User: pboethig
 * Date: 14.12.16
 * Time: 20:10
 */

namespace Mittax\MediaConverterBundle\Collection;
use Mittax\ObjectCollection\CollectionAbstract;

/**
 * Class StorageItem
 * @package Mittax\MediaConverterBundle\Collection
 */
class StorageItem extends CollectionAbstract
{

    /**
     * StorageItem constructor.
     * @param \Mittax\MediaConverterBundle\Entity\Storage\StorageItem[] $items
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
     * @param $filename
     * @return \Mittax\MediaConverterBundle\Entity\Storage\StorageItem[]
     */
    public function filterByFilename( string $filename) : Array
    {
        return $this->filterByPropertyNameAndValue('filename', $filename);
    }

    /**
     * @return \Mittax\MediaConverterBundle\Entity\Storage\StorageItem
     */
    public function getFirstItem() : \Mittax\MediaConverterBundle\Entity\Storage\StorageItem
    {
        return parent::getFirstItem();
    }

    /**
     * @return \Mittax\MediaConverterBundle\Entity\Storage\StorageItem[]
     */
    public function getAllItems() : Array
    {
        return parent::getAllItems();
    }
}
```


### Use the abstraction

Just instanciate your abstraction subclass and pass an array with your object to the constructor.
The resulting collection is typed of your context

```php
        $items = [$fileStorageItem, $fileStorageItem1, $fileStorageItem1];

        $collection = new Collection\StorageItem($items);

        $collection->filter($fileStorageItem->getFilename());

```

The result is a typed list from type StorageItem
