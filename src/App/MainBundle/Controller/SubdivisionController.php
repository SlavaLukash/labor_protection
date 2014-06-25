<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Subdivision;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Subdivision controller.
 *
 */
class SubdivisionController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('subdivision_list'));
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

        return $this->render('MainBundle:Subdivision:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Subdivision();
        } else {
            $entity = $this->findSubdivision($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name')
            ->add('enterprise')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Структурное подразделение создано');
            } else {
                $this->addFlashMessage('success', 'Структурное подразделение сохранено');
            }

            return $this->redirect($this->generateUrl('subdivision_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Subdivision:edit.html.twig', [
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
            ->add('enterprise', 'entity', [
                'class' => 'App\MainBundle\Entity\Enterprise',
                'property' => 'name',
                'required' => false
            ])
            ->add('submit', 'submit', [
                'label' => 'Применить'
            ])
        ;
    }

    protected function createFilterQuery(Form $form)
    {
        $qb = $this->getSubdivisionRepository()->createQueryBuilder('s')
            ->select('s', 'sd')
            ->leftJoin('s.enterprise', 'sd');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('s.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->get('enterprise')->getNormData()) {
            $qb->andWhere('IDENTITY(s.enterprise) = :enterprise');
            $qb->setParameter('enterprise', $form->get('enterprise')->getNormData());
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('s.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('s.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Subdivision
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findSubdivision($id)
    {
        $entity = $this->getSubdivisionRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Структурное подразделение не найдено');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findSubdivision($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Структурное подразделение удалено');

        return $this->redirect($this->generateUrl('subdivision_list'));
    }
}
