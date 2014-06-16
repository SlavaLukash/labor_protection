<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Professionkind;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Professionkind controller.
 *
 */
class ProfessionkindController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('professionkind_list'));
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
        $pagination = $this->paginate($query);

        return $this->render('MainBundle:Professionkind:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Professionkind();
        } else {
            $entity = $this->findProfessionkind($id);
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
                $this->addFlashMessage('success', 'Вид профессии создан');
            } else {
                $this->addFlashMessage('success', 'Вид профессии сохранен');
            }

            return $this->redirect($this->generateUrl('professionkind_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Professionkind:edit.html.twig', [
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
        $qb = $this->getProfessionkindRepository()->createQueryBuilder('pk');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('pk.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('pk.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Professionkind
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findProfessionkind($id)
    {
        $entity = $this->getProfessionkindRepository()->find($id);

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
        $entity = $this->findProfessionkind($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Вид профессии удален');

        return $this->redirect($this->generateUrl('professionkind_list'));
    }
}
