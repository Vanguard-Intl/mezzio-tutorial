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

class AnnouncementsUpdateHandler implements RequestHandlerInterface
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

    public function __construct(EntityManager $entityManager,
                                HalResponseFactory $halResponseFactory,
                                ResourceGenerator $resourceGenerator)
    {
        $this->entityManager = $entityManager;
        $this->halResponseFactory = $halResponseFactory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        // Render and return a response:
//        return new HtmlResponse($this->renderer->render(
//            'announcements::announcements-update',
//            [] // parameters to pass to template
//        ));
        $requestBody = $request->getParsedBody()['Request']['Announcements'];

        if(empty($requestBody)) {
            $result['_error']['error'] = "missing_request";
            $result['_error']['error_description'] = 'No request body sent';

            return new JsonResponse($result, 400);
        }
        $entityRepository = $this->entityManager->getRepository(Announcement::class);

        $entity = $entityRepository->find($request->getAttribute('id'));

        if(empty($entity)) {
            $result['_error']['error'] = "not_found";
            $result['_error']['error_description'] = 'Record Not Found';

            return new JsonResponse($result, 404);
        }
        try {
            $entity->setAnnouncement($requestBody);

            $this->entityManager->flush();
        }catch (ORMException $e) {
            $result['_error']['error'] = "not_updated";
            $result['_error']['error_description'] = $e->getMessage();

            return new JsonResponse($result, 400);
        }

        $resource = $this->resourceGenerator->fromObject($entity, $request);
        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
