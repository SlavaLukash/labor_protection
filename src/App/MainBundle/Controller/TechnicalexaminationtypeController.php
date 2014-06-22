<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Technicalexaminationtype;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Technicalexaminationtype controller.
 *
 */
class TechnicalexaminationtypeController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('technicalexaminationtype_list'));
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

        return $this->render('MainBundle:Technicalexaminationtype:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Technicalexaminationtype();
        } else {
            $entity = $this->findTechnicalexaminationtype($id);
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
                $this->addFlashMessage('success', 'Тип обследования создан');
            } else {
                $this->addFlashMessage('success', 'Тип обследования сохранен');
            }

            return $this->redirect($this->generateUrl('technicalexaminationtype_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Technicalexaminationtype:edit.html.twig', [
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
        $qb = $this->getTechnicalexaminationtypeRepository()->createQueryBuilder('tet');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('tet.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('tet.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Technicalexaminationtype
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTechnicalexaminationtype($id)
    {
        $entity = $this->getTechnicalexaminationtypeRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Тип обследования не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTechnicalexaminationtype($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Тип обследования удален');

        return $this->redirect($this->generateUrl('technicalexaminationtype_list'));
    }
}
