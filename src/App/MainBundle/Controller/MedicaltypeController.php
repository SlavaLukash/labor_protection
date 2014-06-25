<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Medicaltype;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * Medicaltype controller.
 *
 */
class MedicaltypeController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('medicaltype_list'));
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

        return $this->render('MainBundle:Medicaltype:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Medicaltype();
        } else {
            $entity = $this->findMedicaltype($id);
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
                $this->addFlashMessage('success', 'Характер медосмотра создан');
            } else {
                $this->addFlashMessage('success', 'Характер медосмотра сохранен');
            }

            return $this->redirect($this->generateUrl('medicaltype_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Medicaltype:edit.html.twig', [
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
                'label' => 'Применить'
            ])
        ;
    }

    protected function createFilterQuery(Form $form)
    {
        $qb = $this->getMedicaltypeRepository()->createQueryBuilder('mt');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('mt.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('mt.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('mt.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Medicaltype
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findMedicaltype($id)
    {
        $entity = $this->getMedicaltypeRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Характер медосмотра не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findMedicaltype($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Характер медосмотра удален');

        return $this->redirect($this->generateUrl('medicaltype_list'));
    }
}
