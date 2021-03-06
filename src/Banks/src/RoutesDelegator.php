<?php

declare(strict_types=1);

namespace Banks;

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

        // POST a bank
        $app->post('/banks', Handler\BanksCreateHandler::class, 'banks.create');

        // GET one particular bank
        $app->get('/banks/:id', Handler\BanksReadHandler::class, 'banks.read');

        // Update an bank
        $app->put('/banks/:id', Handler\BanksUpdateHandler::class, 'banks.update');

        // DELETE an bank
        $app->delete('/banks/:id', Handler\BanksDeleteHandler::class, 'banks.delete');

        // GET a list of banks
        $app->get('/banks[/]', Handler\BanksListHandler::class, 'banks.list');

        return $app;
    }
}