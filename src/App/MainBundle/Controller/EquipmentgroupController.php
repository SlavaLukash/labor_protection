<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Equipmentgroup;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Equipmentgroup controller.
 *
 */
class EquipmentgroupController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('equipmentgroup_list'));
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

        return $this->render('MainBundle:Equipmentgroup:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Equipmentgroup();
        } else {
            $entity = $this->findEquipmentgroup($id);
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
                $this->addFlashMessage('success', 'Группа оборудования создана');
            } else {
                $this->addFlashMessage('success', 'Группа оборудования сохранена');
            }

            return $this->redirect($this->generateUrl('equipmentgroup_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Equipmentgroup:edit.html.twig', [
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
        $qb = $this->getEquipmentgroupRepository()->createQueryBuilder('eg');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('eg.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('eg.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Equipmentgroup
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findEquipmentgroup($id)
    {
        $entity = $this->getEquipmentgroupRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Группа оборудования не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findEquipmentgroup($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Группа оборудования удалена');

        return $this->redirect($this->generateUrl('equipmentgroup_list'));
    }
}