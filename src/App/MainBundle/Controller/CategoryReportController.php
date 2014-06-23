<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\CategoryReport;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * CategoryReport controller.
 *
 */
class CategoryReportController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('categoryreport_list'));
    }

    public function listAction()
    {
        $builder = $this->createFormBuilder(null, [
            'csrf_protection' => false,
            'method' => 'get'
        ]);

        $this->buildFilterForm($builder);
        $form = $builder->getForm();
        $request = $this->get('request');
        $form->submit($request);

        $query = $this->createFilterQuery($form);
        $pagination = $this->paginate($query, 10);

        return $this->render('MainBundle:CategoryReport:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new CategoryReport();
        } else {
            $entity = $this->findCategoryReport($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Категория отчетов создана');
            } else {
                $this->addFlashMessage('success', 'Категория отчетов сохранена');
            }

            return $this->redirect($this->generateUrl('categoryreport_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:CategoryReport:edit.html.twig', [
            'isNew' => $isNew,
            'entity' => $entity,
            'form'   => $editForm->createView(),
            'isNew' => $isNew
        ]);
    }

    protected function buildFilterForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('name', 'text', [
                'required' => false
            ])
            ->add('submit', 'submit', [
                'label' => 'Показать'
            ])
        ;
    }

    protected function createFilterQuery(Form $form)
    {
        $qb = $this->getCategoryReportRepository()->createQueryBuilder('cr');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('cr.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('cr.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('cr.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|CategoryReport
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findCategoryReport($id)
    {
        $entity = $this->getCategoryReportRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Категория отчетов не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findCategoryReport($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Категория отчетов удалена');

        return $this->redirect($this->generateUrl('categoryreport_list'));
    }
}
