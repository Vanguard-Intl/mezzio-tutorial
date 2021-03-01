<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AnnouncementsCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AnnouncementsCreateHandler
    {
//        return new AnnouncementsCreateHandler($container->get(TemplateRendererInterface::class));
        return new AnnouncementsCreateHandler(
            $container->get(EntityManager::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
