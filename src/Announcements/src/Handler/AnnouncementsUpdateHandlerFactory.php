<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AnnouncementsUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AnnouncementsUpdateHandler
    {
//        return new AnnouncementsUpdateHandler($container->get(TemplateRendererInterface::class));
        return new AnnouncementsUpdateHandler(
            $container->get(EntityManager::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
