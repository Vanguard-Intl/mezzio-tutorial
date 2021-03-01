<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Announcements\Entity\Announcement;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class AnnouncementsReadHandler implements RequestHandlerInterface
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

    public function __construct(
        EntityManager $entityManager,
        HalResponseFactory $halResponseFactory,
        ResourceGenerator $resourceGenerator
    ) {
        $this->entityManager        = $entityManager;
        $this->halResponseFactory   = $halResponseFactory;
        $this->resourceGenerator    = $resourceGenerator;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new JsonResponse($request->getAttributes());
//
//        $id = $request->getAttribute('id', null);
//        $entityRepository = $this->entityManager->getRepository(Announcement::class);
//        $entity = $entityRepository->find($id);
//
//        if(empty($entity)) {
//            $result['_error']['error'] = "missing_request";
//            $result['_error']['error_description'] = 'No request body sent';
//
//            return new JsonResponse($result, 400);
//        }
//
//        $resource = $this->resourceGenerator->fromObject($entity, $request);
//        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
