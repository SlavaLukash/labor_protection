<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Service\ContainerTrait;
use App\MainBundle\Service\DoctrineTrait;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class BaseController extends Controller
{
    use ContainerTrait;
    use DoctrineTrait;

    public function getContainer()
    {
        return $this->container;
    }

    public function addFlashMessage($type, $message)
    {
        $this->getSession()->getFlashBag()->add($type, $message);
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->container->get('session');
    }

    protected function handleGETForm(Form $form)
    {
        $request = $this->getRequest();
        $originalMethod = $request->getMethod();
        $request->setMethod('GET');
        $form->handleRequest($request);
        $request->setMethod($originalMethod);
    }

    /*protected function paginate(Pagination $pagination, QueryBuilder $qb)
    {
        $qb
            ->setFirstResult($pagination->getOffset())
            ->setMaxResults($pagination->getItemNumberPerPage())
        ;
        if ($pagination->getSortField()) {
            $qb->orderBy($pagination->getSortField(), $pagination->getSortDirection());
        }

        return $qb;
    }*/

    /**
     * @param $target
     * @param int $limit
     * @param int $page
     * @param array $options
     * @return AbstractPagination
     */
    public function paginate($target, $limit = 50, $page = 1, $options = array())
    {
        $r = $this->get('request');

        $paginator = $this->getPaginator();

        $pagination = $paginator
            ->paginate(
                $target,
                $r->query->get('page', $r->request->get('page', $page)),
                $r->query->get('limit', $r->request->get('limit', $limit)),
                $options
            );

        $pagination->setTemplate('MainBundle:Pagination:panel_foot.html.twig');
        $pagination->setSortableTemplate('MainBundle:Pagination:sortable_link.html.twig');
//
        return $pagination;
    }

    protected function createSimpleFormBuilder($method = 'POST', $data = [], $options = [], $name = '')
    {
        $builder = $this->getFormFactory()->createNamedBuilder($name, 'form', $data, array_merge([
            'csrf_protection' => false,
        ], $options));

        $builder->setMethod($method);

        return $builder;
    }
}