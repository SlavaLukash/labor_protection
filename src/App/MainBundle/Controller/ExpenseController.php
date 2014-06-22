<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Expense;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Expense controller.
 *
 */
class ExpenseController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('expense_list'));
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

        return $this->render('MainBundle:Expense:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Expense();
        } else {
            $entity = $this->findExpense($id);
        }

        $ch = range(1970, date('Y'));
        $newCh = array();
        foreach($ch as $c) {
            $newCh[$c] = $c;
        }

        $builder = $this->createFormBuilder($entity)
            ->add('enterprise')
            ->add('year', 'choice', array(
                'choices' => $newCh
            ))
            ->add('expensekind')
            ->add('sum1')
            ->add('sum2')
            ->add('sum3')
            ->add('sum4')
            ->add('sum5')
            ->add('sum6')
            ->add('sum7')
            ->add('sum8')
            ->add('sum9')
            ->add('sum10')
            ->add('sum11')
            ->add('sum12')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Категория затраты создана');
            } else {
                $this->addFlashMessage('success', 'Категория затраты сохранена');
            }

            return $this->redirect($this->generateUrl('expense_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Expense:edit.html.twig', [
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
        $qb = $this->getExpenseRepository()->createQueryBuilder('e');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('e.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('e.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Expense
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findExpense($id)
    {
        $entity = $this->getExpenseRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Категория затраты не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findExpense($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Категория затраты удалена');

        return $this->redirect($this->generateUrl('expense_list'));
    }
}
