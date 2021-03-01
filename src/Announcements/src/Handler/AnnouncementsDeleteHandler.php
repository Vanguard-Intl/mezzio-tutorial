<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Announcements\Entity\Announcement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class AnnouncementsDeleteHandler implements RequestHandlerInterface
{
//    /**
//     * @var TemplateRendererInterface
//     */
//    private $renderer;
//
//    public function __construct(TemplateRendererInterface $renderer)
//    {
//        $this->renderer = $renderer;
//    }
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var HalResponseFactory
     */
    private $halResponseFactory;
    /**
     * @var ResourceGenerator
     */
    private $resourceGenerator;

    public  function __construct(EntityManager $entityManager,
                                 HalResponseFactory $halResponseFactory,
                                 ResourceGenerator $resourceGenerator)
    {
        $this->entityManager = $entityManager;
        $this->halResponseFactory = $halResponseFactory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $result = [];

        $entityRepository = $this->entityManager->getRepository(Announcement::class);

        $entity = $entityRepository->find($request->getAttribute('id'));

        if(empty($entity))
        {
            $result['_error']['error'] = 'not_found';
            $result['_error']['error_description'] = 'Record not found';

            return new JsonResponse($result, 404);
        }

        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } catch(ORMException $e)  {
            $result['_error']['error'] = 'not_removed';
            $result['_error']['error_description'] = $e->getMessage();

            return new JsonResponse($result, 400);
        }

        $result['Result']['_embedded']['Announcement'] = ['deleted_id' => $request->getAttribute('id')];

        return new JsonResponse($result);


    }
}
