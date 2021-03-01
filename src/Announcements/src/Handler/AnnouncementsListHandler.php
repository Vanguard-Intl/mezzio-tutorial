<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Announcements\Entity\Announcement;
use Announcements\Entity\AnnouncementCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class AnnouncementsListHandler implements RequestHandlerInterface
{
//    /**@var TemplateRendererInterface */
//    private $renderer;
    /**@var EntityManager */
    protected $entityManager;
    /**@var int */
    protected $pageCount;
    /**@var ResourceGenerator */
    protected $resourceGenerator;
    /**@var HalResponseFactory */
    protected $halResponseFactory;

//    public function __construct(TemplateRendererInterface $renderer)
//    {
//        $this->renderer = $renderer;
//    }
    public function __construct(
        EntityManager $entityManager,
        int $pageCount,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $halResponseFactory
    ) {
        $this->entityManager        = $entityManager;
        $this->pageCount            = $pageCount;
        $this->resourceGenerator    = $resourceGenerator;
        $this->halResponseFactory   = $halResponseFactory;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $repository = $this->entityManager->getRepository(Announcement::class);

        $query = $repository
            ->createQueryBuilder('a')
            ->addOrderBy('a.sort', 'asc')
            ->setMaxResults($this->pageCount)
            ->getQuery();

        $result = new AnnouncementCollection($query);

        $resource = $this->resourceGenerator->fromObject($result, $request);
        return $this->halResponseFactory->createResponse($request, $resource);

        /*
//        $totalItems = count($paginator);
//        $currentPage = ($request->getAttribute('page')) ?: 1; // $request->getAttribute('page') ? $request->getAttribute('page') : 1
//        $totalPageCount = ceil($totalItems / $this->pageCount);
//        $nextPage = min($currentPage + 1, $totalPageCount);
//        $previousPage = max($currentPage - 1, 1);

//        $records = $paginator
//            ->getQuery()
//            ->setFirstResult($this->pageCount * ($currentPage - 1))
//            ->setMaxResults($this->pageCount)
//            ->getResult(Query::HYDRATE_ARRAY);

//        $result['_per_page'] = $this->pageCount;
//        $result['_page'] = $currentPage;
//        $result['_total'] = $totalItems;
//        $result['_total_pages'] = $totalPageCount;
//
//        $result['_links']['self'] = $this->urlHelper->generate('announcements.read', ['page' => $currentPage]);
//        $result['_links']['first'] = $this->urlHelper->generate('announcements.read', ['page' => 1]);
//        $result['_links']['previous'] = $this->urlHelper->generate('announcements.read', ['page' => $previousPage]);
//        $result['_links']['next'] = $this->urlHelper->generate('announcements.read', ['page' => $nextPage]);
//        $result['_links']['last'] = $this->urlHelper->generate('announcements.read', ['page' => $totalPageCount]);
//        $result['_links']['create'] = $this->urlHelper->generate('announcements.create');
//        $result['_links']['read'] = $this->urlHelper->generate('announcements.read', ['page' => 1]);

//        foreach($records as $key => $value) {
//            $records[$key]['_links']['self'] = $this->urlHelper->generate('announcements.view', ['id' => $value['id']]);
//            $records[$key]['_links']['update'] = $this->urlHelper->generate('announcements.update', ['id' => $value['id']]);
//            $records[$key]['_links']['delete'] = $this->urlHelper->generate('announcements.delete', ['id' => $value['id']]);
//        }

//        $result['_embedded']['announcements'] = $records;

//        return new JsonResponse($result);
//        return new HtmlResponse($this->renderer->render(
//            'announcements::announcements-read',
//            [] // parameters to pass to template
//        ));
        */
    }
}
