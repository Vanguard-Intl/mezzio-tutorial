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

class BanksCreateHandler implements RequestHandlerInterface
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
     * BanksCreateHandler constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
//        // Do some work...
//        // Render and return a response:
//        return new HtmlResponse($this->renderer->render(
//            'banks::banks-create',
//            [] // parameters to pass to template
//        ));

        $requestBody = $request->getParsedBody()['Request']['Banks'];

        if(empty($requestBody)) {
            $result['_error']['error'] = "missing_request";
            $result['_error']['error_description'] = 'No request body sent';

            return new JsonResponse($result, 400);
        }
//        return new JsonResponse(($requestBody['parent_id'] ?? 1));
        $entity = new Bank();

        try {

//            $bank = $this->entityManager->find(Bank::class, ($requestBody['parent_id'] ? $requestBody['parent_id'] : 1));
            $bank = $this->entityManager->find(Bank::class, ($requestBody['parent_id'] ?? 1));
            $entity->setParent($bank);
            $entity->setBank($requestBody);
            $entity->setCreated(new \DateTime("now"));

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            $result['_error']['error'] = "not_created";
            $result['_error']['error_description'] = $e->getMessage();

            return new JsonResponse($result, 400);
        }

        return new JsonResponse($requestBody, 200);

    }

}
