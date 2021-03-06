<?php

declare(strict_types=1);

namespace Banks;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Hydrator\ReflectionHydrator;
use Mezzio\Application;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

/**
 * The configuration provider for the Banks module
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
                Handler\BanksReadHandler::class     => Handler\BanksReadHandlerFactory::class,
                Handler\BanksCreateHandler::class   => Handler\BanksCreateHandlerFactory::class,
                Handler\BanksUpdateHandler::class   => Handler\BanksUpdateHandlerFactory::class,
                Handler\BanksDeleteHandler::class   => Handler\BanksDeleteHandlerFactory::class,
                Handler\BanksListHandler::class     => Handler\BanksListHandlerFactory::class,
            ],
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class
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
                'banks'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    /**
     * Returns the Doctrine configuration
     * @return array
     */
    public function getDoctrineEntities() : array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'Banks\Entity' => 'bank_entity',
                    ],
                ],
                'bank_entity' => [
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
                'resource_class'    => Entity\Bank::class,
                'route'             => 'banks.read',
                'extractor'         => ReflectionHydrator::class,
            ],
            [
                '__class__'             => RouteBasedCollectionMetadata::class,
                'collection_class'      => Entity\BankCollection::class,
                'collection_relation'   => 'bank',
                'route'                 => 'banks.list',
            ]
        ];
    }
}
