<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Expensekind;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Expensekind controller.
 *
 */
class ExpensekindController extends BaseController
{

    public function indexAction()
    {
        return $this->redirect($this->generateUrl('expensekind_list'));
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

        return $this->render('MainBundle:Expensekind:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Expensekind();
        } else {
            $entity = $this->findExpensekind($id);
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
                $this->addFlashMessage('success', 'Вид затрат создан');
            } else {
                $this->addFlashMessage('success', 'Вид затрат сохранен');
            }

            return $this->redirect($this->generateUrl('expensekind_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Expensekind:edit.html.twig', [
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
        $qb = $this->getExpensekindRepository()->createQueryBuilder('ek');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('ek.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('ek.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Expensekind
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findExpensekind($id)
    {
        $entity = $this->getExpensekindRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Вид затрат не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findExpensekind($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Вид затрат удален');

        return $this->redirect($this->generateUrl('expensekind_list'));
    }
}
