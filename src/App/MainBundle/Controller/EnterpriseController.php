<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Enterprise;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Enterprise controller.
 *
 */
class EnterpriseController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('enterprise_list'));
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

        return $this->render('MainBundle:Enterprise:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Enterprise();
        } else {
            $entity = $this->findEnterprise($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name')
            ->add('address')
            ->add('okved')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Предприятие создано');
            } else {
                $this->addFlashMessage('success', 'Предприятие сохранено');
            }

            return $this->redirect($this->generateUrl('enterprise_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Enterprise:edit.html.twig', [
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
        $qb = $this->getEnterpriseRepository()->createQueryBuilder('e');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('e.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('e.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('e.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Enterprise
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findEnterprise($id)
    {
        $entity = $this->getEnterpriseRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Предприятие не найдено');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findEnterprise($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Подразделение удалено');

        return $this->redirect($this->generateUrl('enterprise_list'));
    }
}
