<?php

declare(strict_types=1);

namespace Banks\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AnnouncementsReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AnnouncementsReadHandler
    {
        return new AnnouncementsReadHandler($container->get(TemplateRendererInterface::class));
    }
}
