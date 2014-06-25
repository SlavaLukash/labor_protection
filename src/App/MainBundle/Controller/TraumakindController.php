<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Traumakind;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Traumakind controller.
 *
 */
class TraumakindController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('traumakind_list'));
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

        return $this->render('MainBundle:Traumakind:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Traumakind();
        } else {
            $entity = $this->findTraumakind($id);
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
                $this->addFlashMessage('success', 'Вид происшествия создан');
            } else {
                $this->addFlashMessage('success', 'Вид происшествия сохранен');
            }

            return $this->redirect($this->generateUrl('traumakind_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Traumakind:edit.html.twig', [
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
        $qb = $this->getTraumakindRepository()->createQueryBuilder('tk');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('tk.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('tk.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('tk.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Traumakind
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTraumakind($id)
    {
        $entity = $this->getTraumakindRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Вид происшествия не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTraumakind($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Вид происшествия удален');

        return $this->redirect($this->generateUrl('traumakind_list'));
    }
}