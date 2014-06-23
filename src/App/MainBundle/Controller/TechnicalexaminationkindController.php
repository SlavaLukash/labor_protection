<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Technicalexaminationkind;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * Technicalexaminationkind controller.
 *
 */
class TechnicalexaminationkindController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('technicalexaminationkind_list'));
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

        return $this->render('MainBundle:Technicalexaminationkind:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Technicalexaminationkind();
        } else {
            $entity = $this->findTechnicalexaminationkind($id);
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
                $this->addFlashMessage('success', 'Вид обследования создан');
            } else {
                $this->addFlashMessage('success', 'Вид обследования сохранен');
            }

            return $this->redirect($this->generateUrl('technicalexaminationkind_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Technicalexaminationkind:edit.html.twig', [
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
        $qb = $this->getTechnicalexaminationkindRepository()->createQueryBuilder('tek');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('tek.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('tek.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('tek.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Technicalexaminationkind
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTechnicalexaminationkind($id)
    {
        $entity = $this->getTechnicalexaminationkindRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Вид обследования  не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTechnicalexaminationkind($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Вид обследования удален');

        return $this->redirect($this->generateUrl('technicalexaminationkind_list'));
    }
}
