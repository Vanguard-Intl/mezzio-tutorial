<?php

declare(strict_types=1);

namespace Banks\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class BanksUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : BanksUpdateHandler
    {
        return new BanksUpdateHandler($container->get(TemplateRendererInterface::class));
    }
}
