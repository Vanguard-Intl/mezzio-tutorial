<?php

declare(strict_types=1);

namespace Banks\Handler;

use Banks\Entity\Bank;
use Banks\Entity\BankCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class BanksListHandler implements RequestHandlerInterface
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
    /** @var int */
    protected $pageCount;
    /** @var ResourceGenerator */
    protected $resourceGenerator;
    /** @var HalResponseFactory */
    protected $halResponseFactory;

    /**
     * BanksListHandler constructor.
     * @param EntityManager $entityManager
     * @param int $pageCount
     * @param ResourceGenerator $resourceGenerator
     * @param HalResponseFactory $halResponseFactory
     */
    public function __construct(EntityManager $entityManager,
                                int $pageCount,
                                ResourceGenerator $resourceGenerator,
                                HalResponseFactory $halResponseFactory)
    {
        $this->entityManager = $entityManager;
        $this->pageCount = $pageCount;
        $this->resourceGenerator = $resourceGenerator;
        $this->halResponseFactory = $halResponseFactory;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
//        // Do some work...
//        // Render and return a response:
//        return new HtmlResponse($this->renderer->render(
//            'banks::banks-list',
//            [] // parameters to pass to template
//        ));

        $repository = $this->entityManager->getRepository(Bank::class);

        $entity = $repository
            ->createQueryBuilder('b')
            ->addOrderBy('b.name', 'asc')
            ->setMaxResults($this->pageCount)
            ->getQuery();

        $result = new BankCollection($entity);

        if(empty($result))
        {
            $result['_error']['error'] = "not_found";
            $result['_error']['error_description'] = "No Record Found.";

            return new JsonResponse($result, 404);
        }

        $resource = $this->resourceGenerator->fromObject($result, $request);
        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
