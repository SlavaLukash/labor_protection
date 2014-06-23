<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Equipment;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Equipment controller.
 *
 */
class EquipmentController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('equipment_list'));
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

        return $this->render('MainBundle:Equipment:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Equipment();
        } else {
            $entity = $this->findEquipment($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name', 'text', array('required' => true))
            ->add('model', null, array('required' => true))
            ->add('registrationnumber')
            ->add('internalnumber')
            ->add('factorynumber')
            ->add('manufacturer')
//            ->add('productiondate')
//            ->add('startupdate')
            ->add('productiondate', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('startupdate', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('life')
            ->add('equipmentsubgroup')
            ->add('subdivision')
            ->add('registrationtype')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Оборудование создано');
            } else {
                $this->addFlashMessage('success', 'Оборудование сохранено');
            }

            return $this->redirect($this->generateUrl('equipment_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Equipment:edit.html.twig', [
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
        $qb = $this->getEquipmentRepository()->createQueryBuilder('e')
            ->select('e', 'enterp', 'subd', 'esg')
            ->leftJoin('e.subdivision', 'subd')
            ->leftJoin('subd.enterprise', 'enterp')
            ->leftJoin('e.equipmentsubgroup', 'esg');

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
     * @return null|Equipment
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findEquipment($id)
    {
        $entity = $this->getEquipmentRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Оборудование не найдено');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findEquipment($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Оборудование удалено');

        return $this->redirect($this->generateUrl('equipment_list'));
    }
}
