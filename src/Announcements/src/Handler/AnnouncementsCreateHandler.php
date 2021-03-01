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

class AnnouncementsCreateHandler implements RequestHandlerInterface
{
//    /**
//     * @var TemplateRendererInterface
//     */
//    private $renderer;

//    public function __construct(TemplateRendererInterface $renderer)
//    {
//        $this->renderer = $renderer;
//    }
    /** @var EntityManager */
    protected $entityManager;
    /** @var HalResponseFactory */
    protected $halResponseFactory;
    /** @var ResourceGenerator */
    protected $resourceGenerator;

    public function __construct(EntityManager $entityManager,
                                HalResponseFactory $halResponseFactory,
                                ResourceGenerator $resourceGenerator
    )
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
//            'announcements::announcements-create',
//            [] // parameters to pass to template
//        ));

        $requestBody = $request->getParsedBody()['Request']['Announcements'];

        if(empty($requestBody)) {
            $result['_error']['error'] = "missing_request";
            $result['_error']['error_description'] = 'No request body sent';

            return new JsonResponse($result, 400);
        }

        $entity = new Announcement();

        try {
            $entity->setAnnouncement($requestBody);
            $entity->setCreated(new \Datetime("now"));

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }catch (ORMException $e) {
            $result['_error']['error'] = "not_created";
            $result['_error']['error_description'] = $e->getMessage();

            return new JsonResponse($result, 400);
        }

        $resource = $this->resourceGenerator->fromObject($entity, $request);
        return $this->halResponseFactory->createResponse($request, $resource);

    }
}
