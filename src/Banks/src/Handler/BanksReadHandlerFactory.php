<?php

declare(strict_types=1);

namespace Banks\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class BanksReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : BanksReadHandler
    {
//        return new BanksReadHandler($container->get(TemplateRendererInterface::class));
        return new BanksReadHandler($container->get(EntityManager::class));
    }
}
