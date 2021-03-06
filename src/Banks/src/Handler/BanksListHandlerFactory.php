<?php

declare(strict_types=1);

namespace Banks\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Template\TemplateRendererInterface;
use phpDocumentor\Reflection\Types\Integer;
use Psr\Container\ContainerInterface;

class BanksListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : BanksListHandler
    {
//        return new BanksListHandler($container->get(TemplateRendererInterface::class));
        return new BanksListHandler(
            $container->get(EntityManager::class),
            $container->get('config')['page_size'],
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );
    }
}
