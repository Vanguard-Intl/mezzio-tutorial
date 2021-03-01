<?php

declare(strict_types=1);

namespace Announcements;

use Announcements\Entity\Announcement;
use Announcements\Entity\AnnouncementCollection;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Hydrator\ReflectionHydrator;
use Mezzio\Application;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

/**
 * The configuration provider for the Announcements module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'doctrine'     => $this->getDoctrineEntities(),
            MetadataMap::class => $this->getHalMetadataMap(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                Handler\AnnouncementsCreateHandler::class => Handler\AnnouncementsCreateHandlerFactory::class,
                Handler\AnnouncementsReadHandler::class => Handler\AnnouncementsReadHandlerFactory::class,
                Handler\AnnouncementsUpdateHandler::class => Handler\AnnouncementsUpdateHandlerFactory::class,
                Handler\AnnouncementsDeleteHandler::class => Handler\AnnouncementsDeleteHandlerFactory::class,
                Handler\AnnouncementsListHandler::class => Handler\AnnouncementsListHandlerFactory::class,
            ],
            'delegators' => [
                Application::class => [
                        RoutesDelegator::class,
                    ],
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'announcements'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
//    public function getRouteConfig() : array
//    {
//        return [
//            [
//                'path'              => '/announcements/',
//                'middleware'        => Handler\AnnouncementsReadHandler::class,
//                'allowed_methods'   => ['GET'],
//            ]
//        ];
//    }

    /**
     * Returns the entities array
     */
    public function getDoctrineEntities(): array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'Announcements\Entity' => 'announcement_entity',
                    ],
                ],
                'announcement_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }

    /**
     * Returns the Metadata array
     */
    public function getHalMetadataMap() : array
    {
        return [
            [
                '__class__'         => RouteBasedResourceMetadata::class,
                'resource_class'    => Announcement::class,
                'route'             => 'announcements.read',
                'extractor'         => ReflectionHydrator::class,
            ],
            [
                '__class__'             => RouteBasedCollectionMetadata::class,
                'collection_class'      => AnnouncementCollection::class,
                'collection_relation'   => 'announcement',
                'route'                 => 'announcements.list',
            ]
        ];
    }
}
/*
 *
 * Package container-interop/container-interop is abandoned, you should avoid using it. Use psr/container instead.
 * Package doctrine/reflection is abandoned, you should avoid using it. Use roave/better-reflection instead.
 *
 * */