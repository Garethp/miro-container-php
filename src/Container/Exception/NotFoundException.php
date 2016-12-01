<?php

namespace Miro\Container\Exception;

class NotFoundException extends \Exception implements
    \Psr\Container\Exception\NotFoundException,
    \Interop\Container\Exception\NotFoundException
{

}
