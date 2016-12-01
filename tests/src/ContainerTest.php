<?php

namespace Miro\Test;

use Interop\Container\ContainerInterface;
use Miro\Container;
use Miro\Container\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testContainerImplementsInterop()
    {
        $container = new Container();

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(\Psr\Container\ContainerInterface::class, $container);
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

        $this->assertSame('testString', $container->get('test'));
    }

    public function testLambdaFunctionsLoadLazily()
    {
        $container = new Container();
        $container['lazy-load'] = function () {
            $this->fail();
        };
        $container['test'] = 'test';

        $container->get('test');
    }

    public function testLambdaFunctionOnlyCalledOnce()
    {
        $container = new Container();
        $counter = 0;
        $container['function'] = function () use (&$counter) {
            $counter++;
            return 'test';
        };

        $this->assertSame('test', $container->get('function'));
        $this->assertSame('test', $container->get('function'));
        $this->assertSame(1, $counter);
    }

    public function testConstructorIsASetter()
    {
        $container = new Container([
            'test' => 'testInput'
        ]);

        $this->assertTrue($container->has('test'));
        $this->assertSame('testInput', $container->get('test'));
    }

    public function testGettingNonExistentKeyThrowsException()
    {
        $this->expectException(NotFoundException::class);
        $this->expectException(\Interop\Container\Exception\NotFoundException::class);
        $this->expectException(\Psr\Container\Exception\NotFoundException::class);

        $container = new Container();
        $container->get('test');
    }
}
