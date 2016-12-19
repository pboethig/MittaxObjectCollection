<?php
/**
 * Created by PhpStorm.
 * User: pboethig
 * Date: 14.12.16
 * Time: 22:19
 */

namespace Mittax\ObjectCollection;

use \InvalidArgumentException;

/**
 * Class CollectionAbstract
 * @package Mittax\MediaConverterBundle\Collection
 */
class CollectionAbstract implements ICollection
{
    /**
     * @var array
     */
    private $objects = [];

    /**
     * @var bool
     */
    private $reset = false;

    /**
     * @var int
     */
    private $countObjects = 0;

    /**
     * @var int
     */
    private $iterations = 0;

    /**
     * @var string
     */
    private $_uuid;

    /**
     * CollectionAbstract constructor.
     * @param ICollectionItem[] $items
     */
    public function __construct(Array $items = null)
    {

        $this->_uuid = microtime();

        $this->resetIterator();

        if ($items)
        {
            foreach ($items as $item)
            {
                $this->add($item);
            }
        }
    }

    /**
     * @return ICollection
     */
    public function getAllItems()
    {
        if (empty($this->objects))
        {
            throw new InvalidArgumentException('Collection is empty');
        }

        return $this->objects;
    }

    /**
     * @param $obj
     */
    public function add(ICollectionItem $obj)
    {
        if (!isset($this->objects[$obj->getUuid()]))
        {
            $this->objects[$obj->getUuid()] = $obj;

            $this->countObjects++;
        }
    }

    public function next()
    {
        $num = ($this->isLast()) ? 0 : $this->iterations + 1;

        $this->iterations = $num;
    }


    public function isOdd() : bool
    {
        return $this->iterations%2==1;
    }

    /**
     * @return bool
     */
    public function isEven() : bool
    {
        return $this->iterations%2==0;
    }

    /**
     * @param $propertyName
     * @param $value
     * @return ICollectionItem[]
     */
    public function getByPropertyNameAndValue($propertyName, $value) : Array
    {
        $list = [];

        $methodName = "get".ucwords($propertyName);

        foreach ($this->objects as $key => $obj)
        {
            if ($obj->{$methodName}() == $value)
            {
                $list[] = $this->objects[$key];
            }
        }

        return $list;
    }

    /**
     * @param $propertyName
     * @param $value
     * @return $this
     */
    public function filterByPropertyNameAndValue($propertyName, $value)
    {
        $methodName = "get" . ucwords($propertyName);

        $collection = new self;

        foreach ($this->objects as $key => $obj)
        {
            if ($obj->{$methodName}() == $value)
            {
                $collection->add($obj);
            }
        }

        return $collection;
    }

    /**
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function getFirstItem()
    {
        if (empty($this->objects))
        {
            throw new InvalidArgumentException('No items in collection');
        }

        return reset($this->objects);
    }

    /**
     * @return ICollectionItem
     */
    public function getLastItem()
    {
        if (empty($this->objects))
        {
            throw new InvalidArgumentException('No items in collection');
        }

        return end($this->objects);
    }

    /**
     * @param $propertyName
     * @param $value
     * @return bool
     */
    public function removeByPropertyNameAndValue($propertyName, $value) : bool
    {
        $methodName = "get" . ucwords($propertyName);

        foreach ($this->objects as $key => $obj)
        {
            if ($obj->{$methodName}() == $value)
            {
                unset($this->objects[$key]);

                $this->objects = array_values($this->objects);

                $this->countObjects--;

                $this->iterations = ($this->iterations >= 0) ? $this->iterations - 1 : 0;

                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isLast() : bool
    {
        return (($this->countObjects-1) == $this->iterations);
    }

    /**
     * @param $num
     * @return mixed
     */
    public function getByKey($num)
    {
        return (isset($this->objects[$num])) ? $this->objects[$num] : false;
    }


    public function removeCurrent()
    {
        unset($this->objects[$this->iterations]);

        $this->objects = array_values($this->objects);

        if ($this->iterations == 0)
        {
            $this->reset = true;

        }
        elseif ($this->iterations > 0)
        {
            $this->iterations--;
        }
        else
        {
            $this->iterations = 0;
        }

        $this->countObjects--;
    }


    public function removeLast()
    {
        unset($this->objects[$this->countObjects-1]);

        $this->objects = array_values($this->objects);

        if ($this->iterations == $this->countObjects-1)
        {
            $this->resetIterator();
        }

        $this->countObjects--;
    }

    /**
     * @param $propertyName
     * @param string $type
     * @throws InvalidArgumentException
     */
    public function sortByPropertyNameAndType($propertyName, $type='r')
    {
        $tempArray = array();
        $newObjects = array();

        while ($obj = $this->iterate())
        {
            $tempArray[] = call_user_func([$obj, 'get' . ucwords($propertyName)]);
        }

        switch($type)
        {
            case 'r':
                asort($tempArray);
                break;
            case 'rr':
                arsort($tempArray);
                break;
            case 'n':
                asort($tempArray, SORT_NUMERIC);
                break;
            case 'nr':
                arsort($tempArray, SORT_NUMERIC);
                break;
            case 's':
                asort($tempArray, SORT_STRING);
                break;
            case 'sr':
                arsort($tempArray, SORT_STRING);
                break;
            default:
                throw new InvalidArgumentException(
                    'Collection->sortByPropertyNameAndType():
                    illegal sort type "'.$type.'"'
                );
        }

        foreach ($tempArray as $key => $val)
        {
            $newObjects[] = $this->objects[$key];
        }

        $this->objects = $newObjects;
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return ($this->countObjects == 0);
    }

    /**
     * @return bool
     */
    public function getCurrent() : bool
    {
        return $this->objects[$this->iterations];
    }


    public function setCurrent($obj)
    {
        $this->objects[$this->iterations] = $obj;
    }

    /**
     * @param $iterateNum
     * @return bool|mixed
     */
    public function getObjectByIterateNum($iterateNum)
    {
        return (
        isset($this->objects[$iterateNum])
            ? $this->objects[$iterateNum]
            : false
        );
    }

    /**
     * @return bool
     */
    public function iterate()
    {
        if ($this->iterations < 0)
        {
            $this->iterations = 0;
        }

        if ($this->reset)
        {
            $this->reset = false;
        }
        else
        {
            $this->iterations++;
        }

        if ($this->iterations == $this->countObjects || !isset($this->objects[$this->iterations]))
        {
            $this->resetIterator();
            return false;
        }

        return $this->getCurrent();
    }

    public function resetIterator()
    {
        $this->iterations = 0;

        $this->reset = true;
    }

    /**
     * @return mixed
     */
    public function getIterateNum() : int
    {
        return $this->iterations;
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return $this->countObjects;
    }

    /**
     * @return ICollection
     */
    public function getCollection()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->_uuid;
    }
}
