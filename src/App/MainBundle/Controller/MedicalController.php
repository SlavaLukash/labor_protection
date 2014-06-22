<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Medical;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Medical controller.
 *
 */
class MedicalController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('medical_list'));
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

        return $this->render('MainBundle:Medical:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Medical();
        } else {
            $entity = $this->findMedical($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('enterprise', 'entity', array(
                'class' => 'MainBundle:Enterprise',
                'mapped' => false,
                'attr' => array('class' => 'med_enterprise'),
//                'choices' => $options['OTparams']['aEnterprise'],
            ))
            ->add('subdivision', 'entity', array(
                'class' => 'MainBundle:Subdivision',
                'mapped' => false,
                'attr' => array('class' => 'med_subdivision'),
//                'choices' => $options['OTparams']['aSubdivision'],
            ))
            ->add('employee', 'entity', array(
                'class' => 'MainBundle:Employee',
                'attr' => array('class' => 'med_employee'),
//                'choices' => $options['OTparams']['aEmployee'],
            ))
            ->add('medicalkind', null, array(
                'empty_value' => false,
            ))
            ->add('medicaltype', null, array(
                'empty_value' => false,
            ))
            ->add('dateplan', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('datefact', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('comment')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Графика медосмотров создан');
            } else {
                $this->addFlashMessage('success', 'Графика медосмотров сохранен');
            }

            return $this->redirect($this->generateUrl('medical_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Medical:edit.html.twig', [
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
        $qb = $this->getMedicalRepository()->createQueryBuilder('m');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('m.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('m.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Medical
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findMedical($id)
    {
        $entity = $this->getMedicalRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Сотрудник не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findMedical($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Графика медосмотров удален');

        return $this->redirect($this->generateUrl('medical_list'));
    }
}
