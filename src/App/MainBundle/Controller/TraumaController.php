<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Trauma;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trauma controller.
 *
 */
class TraumaController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('trauma_list'));
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

        return $this->render('MainBundle:Trauma:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Trauma();
        } else {
            $entity = $this->findTrauma($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('datetrauma', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('traumareport')
            ->add('hoursstart')
            ->add('employee', 'entity', array(
                'class' => 'MainBundle:Employee',
                'empty_value' => false,
//                'choices' => $options['OTparams']['aEmployee'],
            ))
            ->add('traumacause')
            ->add('traumakind')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Случай травматизма создан');
            } else {
                $this->addFlashMessage('success', 'Случай травматизма сохранен');
            }

            return $this->redirect($this->generateUrl('trauma_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Trauma:edit.html.twig', [
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
        $qb = $this->getTraumaRepository()->createQueryBuilder('t')
            ->select('t', 'e', 'enterp')
            ->leftJoin('t.employee', 'e')
            ->leftJoin('e.enterprise', 'enterp');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('t.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('t.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('t.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Trauma
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTrauma($id)
    {
        $entity = $this->getTraumaRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Случай травматизма не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTrauma($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Случай травматизма удален');

        return $this->redirect($this->generateUrl('trauma_list'));
    }
}
