<?php

declare(strict_types=1);

namespace Banks\Handler;

use Banks\Entity\Bank;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\TransactionRequiredException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class BanksReadHandler implements RequestHandlerInterface
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

    /** @var EntityManager */
    protected $entityManager;

    /**
     * BanksReadHandler constructor.
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
//            'banks::banks-read',
//            [] // parameters to pass to template
//        ));

        $id = $request->getAttribute('id');
        $repositoryBank = $this->entityManager->getRepository(Bank::class);
        $entity = $repositoryBank->find($id);

        //$paginator = new Paginator($query);

        //$entity = $paginator->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if(empty($entity))
        {
            $result['_error']['error'] = "not_found";
            $result['_error']['error_description'] = "No Record Found.";

            return new JsonResponse($result, 404);
        }

        $result['_embedded']['bank'] = $entity;

        return new JsonResponse($result, 200);
    }
}
