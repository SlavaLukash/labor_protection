<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Equipmentsubgroup;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Equipmentsubgroup controller.
 *
 */
class EquipmentsubgroupController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('equipmentsubgroup_list'));
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

        return $this->render('MainBundle:Equipmentsubgroup:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Equipmentsubgroup();
        } else {
            $entity = $this->findEquipmentsubgroup($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name')
            ->add('equipmentgroup')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Подгруппа оборудования создана');
            } else {
                $this->addFlashMessage('success', 'Подгруппа оборудования сохранена');
            }

            return $this->redirect($this->generateUrl('equipmentsubgroup_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Equipmentsubgroup:edit.html.twig', [
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
        $qb = $this->getEquipmentsubgroupRepository()->createQueryBuilder('esg')
                    ->select('esg', 'eg')
                    ->leftJoin('esg.equipmentgroup', 'eg');


        if ($form->get('name')->getNormData()) {
            $qb->andWhere('esg.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('esg.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('esg.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Equipmentsubgroup
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findEquipmentsubgroup($id)
    {
        $entity = $this->getEquipmentsubgroupRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Подгруппа оборудования не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findEquipmentsubgroup($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Подгруппа оборудования удалена');

        return $this->redirect($this->generateUrl('equipmentsubgroup_list'));
    }
}
