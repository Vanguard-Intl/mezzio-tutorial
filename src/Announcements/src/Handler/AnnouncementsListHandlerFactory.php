<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;


class AnnouncementsListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AnnouncementsListHandler
    {
//        return new AnnouncementsReadHandler($container->get(TemplateRendererInterface::class));
        return new AnnouncementsListHandler(
            $container->get(EntityManager::class),
            $container->get('config')['page_size'],
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );

    }
}
