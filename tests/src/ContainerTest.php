<?php

namespace Miro\Container\Test;

use Interop\Container\ContainerInterface;
use Miro\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testContainerImplementsInterop()
    {
        $container = new Container();

        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function testHasIsFalseFirst()
    {
        $container = new Container();

        $this->assertFalse($container->has('test'));
    }

    public function testHasIsTrueWhenItHas()
    {
        $container = new Container();
        $container['test'] = 'testString';

        $this->assertTrue($container->has('test'));
    }

    public function testGetScalar()
    {
        $container = new Container();
        $container['test'] = 'testString';

        $this->assertSame('testString', $container['test']);
    }
}
