<?php

namespace Miro\Container;

class FactoryValue implements ValueInterface
{
    /**
     * @var $callable
     */
    private $callable;

    private $result;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function getValue()
    {
        if (!$this->result) {
            $callback = $this->callable;
            $this->result = $callback();
        }

        return $this->result;
    }
}
