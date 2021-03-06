<?php

declare(strict_types=1);

namespace Banks\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class BanksCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : BanksCreateHandler
    {
//        return new BanksCreateHandler($container->get(TemplateRendererInterface::class));
        return new BanksCreateHandler($container->get(EntityManager::class));
    }
}
