<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Technicalexaminationcause;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Technicalexaminationcause controller.
 *
 */
class TechnicalexaminationcauseController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('technicalexaminationcause_list'));
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

        return $this->render('MainBundle:Technicalexaminationcause:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Technicalexaminationcause();
        } else {
            $entity = $this->findTechnicalexaminationcause($id);
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
                $this->addFlashMessage('success', 'Причина обследования создана');
            } else {
                $this->addFlashMessage('success', 'Причина обследования сохранена');
            }

            return $this->redirect($this->generateUrl('technicalexaminationcause_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Technicalexaminationcause:edit.html.twig', [
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
        $qb = $this->getTechnicalexaminationcauseRepository()->createQueryBuilder('tec');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('tec.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('tec.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('tec.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Technicalexaminationcause
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTechnicalexaminationcause($id)
    {
        $entity = $this->getTechnicalexaminationcauseRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Причина обследования не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTechnicalexaminationcause($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Причина обследования удалена');

        return $this->redirect($this->generateUrl('technicalexaminationcause_list'));
    }
}
