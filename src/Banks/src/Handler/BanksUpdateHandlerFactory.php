<?php

declare(strict_types=1);

namespace Banks\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class BanksUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : BanksUpdateHandler
    {
//        return new BanksUpdateHandler($container->get(TemplateRendererInterface::class));
        return new BanksUpdateHandler($container->get(EntityManager::class));
    }
}
