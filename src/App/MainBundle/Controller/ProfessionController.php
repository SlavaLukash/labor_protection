<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Profession;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Profession controller.
 *
 */
class ProfessionController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('profession_list'));
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

        return $this->render('MainBundle:Profession:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Profession();
        } else {
            $entity = $this->findProfession($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name')
            ->add('professionkind', null, [
                'constraints' => [
                    new NotBlank([]),
                ]
            ])
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Профессия создана');
            } else {
                $this->addFlashMessage('success', 'Профессия сохранена');
            }

            return $this->redirect($this->generateUrl('profession_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Profession:edit.html.twig', [
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
        $qb = $this->getProfessionRepository()->createQueryBuilder('p');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('p.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('p.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Profession
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findProfession($id)
    {
        $entity = $this->getProfessionRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Профессия не найдена');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findProfession($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Профессия удалена');

        return $this->redirect($this->generateUrl('profession_list'));
    }
}
