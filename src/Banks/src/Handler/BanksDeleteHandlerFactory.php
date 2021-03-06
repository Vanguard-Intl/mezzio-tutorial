<?php

declare(strict_types=1);

namespace Banks\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class BanksDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : BanksDeleteHandler
    {
//        return new BanksDeleteHandler($container->get(TemplateRendererInterface::class));
        return new BanksDeleteHandler($container->get(EntityManager::class));
    }
}
