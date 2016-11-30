<?php

namespace Miro\Container;

use Miro\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface, \Interop\Container\ContainerInterface, \ArrayAccess
{
    private $container = [];
    private $values = [];

    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException();
        }

        if (!isset($this->values[$id])) {
            $this->values[$id] = $this->container[$id]();
        }

        return $this->values[$id];
    }

    private function set($index, $value)
    {
        if (!is_callable($value)) {
            $this->values[$index] = $value;
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
