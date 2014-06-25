<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Traumacause;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Traumacause controller.
 *
 */
class TraumacauseController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('traumacause_list'));
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

        return $this->render('MainBundle:Traumacause:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Traumacause();
        } else {
            $entity = $this->findTraumacause($id);
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
                $this->addFlashMessage('success', 'Причина происшествия создана');
            } else {
                $this->addFlashMessage('success', 'Причина происшествия сохранена');
            }

            return $this->redirect($this->generateUrl('traumacause_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Traumacause:edit.html.twig', [
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
        $qb = $this->getTraumacauseRepository()->createQueryBuilder('tc');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('tc.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('tc.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('tc.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Traumacause
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTraumacause($id)
    {
        $entity = $this->getTraumacauseRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Причина происшествия не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTraumacause($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Причина происшествия удалена');

        return $this->redirect($this->generateUrl('traumacause_list'));
    }
}
