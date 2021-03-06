<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

class AppTestFactory
{
    public function __invoke(ContainerInterface $container) : AppTest
    {
        return new AppTest();
    }
}
