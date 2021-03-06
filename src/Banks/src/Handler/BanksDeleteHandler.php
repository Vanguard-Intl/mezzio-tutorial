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

class BanksDeleteHandler implements RequestHandlerInterface
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
     * BanksDeleteHandler constructor.
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
//            'banks::banks-delete',
//            [] // parameters to pass to template
//        ));
        $id = $request->getAttribute('id');
        $repository = $this->entityManager->getRepository(Bank::class);
        $entity = $repository->find($id);

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

        $result['_embedded']['Bank'] = ['deleted_id' => $id];

        return new JsonResponse($result);

    }
}
