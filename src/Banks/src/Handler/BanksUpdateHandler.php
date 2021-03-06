<?php

declare(strict_types=1);

namespace Banks\Handler;

use Banks\Entity\Bank;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class BanksUpdateHandler implements RequestHandlerInterface
{
//    /** @var TemplateRendererInterface */
//    private $renderer;
//
//    public function __construct(TemplateRendererInterface $renderer)
//    {
//        $this->renderer = $renderer;
//    }

    /** @var EntityManager */
    protected $entityManager;

    /**
     * BanksUpdateHandler constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
//        // Do some work...
//        // Render and return a response:
//        return new HtmlResponse($this->renderer->render(
//            'banks::banks-update',
//            [] // parameters to pass to template
//        ));
        $requestBody = $request->getParsedBody()['Request']['Banks'];

        if(empty($requestBody)) {
            $result['_error']['error'] = "missing_request";
            $result['_error']['error_description'] = 'No request body sent';

            return new JsonResponse($result, 400);
        }
        $id = $request->getAttribute('id');
        $repository = $this->entityManager->getRepository(Bank::class);
        $entity = $repository->find($id);

        if(empty($entity)) {
            $result['_error']['error'] = "not_found";
            $result['_error']['error_description'] = 'Record Not Found';

            return new JsonResponse($result, 404);
        }
        try {
            $entity->setBank($requestBody);

            $this->entityManager->flush();
        } catch(ORMException $e) {
            $result['_error']['error'] = "not_updated";
            $result['_error']['error_description'] = $e->getMessage();
        }

        return new JsonResponse($requestBody);
    }
}
