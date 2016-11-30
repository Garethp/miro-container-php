<?php

namespace Miro\Container;

use Interop\Container\ContainerInterface;

class Container implements ContainerInterface, \ArrayAccess
{
    /**
     * @var ValueInterface[]
     */
    private $container = [];

    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function get($id)
    {
        return $this->container[$id]->getValue();
    }

    private function set($index, $value)
    {
        if (is_callable($value)) {
            $value = new FactoryValue($value);
        } else {
            $value = new ScalarValue($value);
        }

        $this->container[$index] = $value;
    }

    public function has($id)
    {
        return $this->offsetExists($id);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->container);
    }

    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}
