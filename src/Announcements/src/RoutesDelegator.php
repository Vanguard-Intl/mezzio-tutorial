<?php

declare(strict_types=1);

namespace Announcements;

use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    function __invoke(ContainerInterface $container, $serviceName, callable $callback) : Application
    {
        /** @var $app Application */
        $app = $callback();

        // POST an announcement
        $app->post('/announcements', Handler\AnnouncementsCreateHandler::class, 'announcements.create');

        // GET one particular announcement
        $app->get('/announcements/:id', Handler\AnnouncementsReadHandler::class, 'announcements.read');

        // Update an announcement
        $app->put('/announcements/:id', Handler\AnnouncementsUpdateHandler::class, 'announcements.update');

        // DELETE an announcement
        $app->delete('/announcements/:id', Handler\AnnouncementsDeleteHandler::class, 'announcements.delete');

        // GET a list of announcements
        $app->get('/announcements[/]', Handler\AnnouncementsListHandler::class, 'announcements.list');

        return $app;
    }
}