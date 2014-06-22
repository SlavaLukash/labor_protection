<?php

namespace App\MainBundle\Controller;
use App\MainBundle\Entity\Technicalexamination;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Technicalexamination controller.
 *
 */
class TechnicalexaminationController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('technicalexamination_list'));
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

        return $this->render('MainBundle:Technicalexamination:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Technicalexamination();
        } else {
            $entity = $this->findTechnicalexamination($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('resulttext')
//            ->add('plandate')
//            ->add('factdate')
            ->add('plandate', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('factdate', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input')
            ))
            ->add('equipment')
            ->add('technicalexaminationkind')
            ->add('technicalexaminationcause')
            ->add('technicalexaminationtype')
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Техническое освидетельствование создано');
            } else {
                $this->addFlashMessage('success', 'Техническое освидетельствование сохранено');
            }

            return $this->redirect($this->generateUrl('technicalexamination_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Technicalexamination:edit.html.twig', [
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
        $qb = $this->getTechnicalexaminationRepository()->createQueryBuilder('te');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('te.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('te.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Technicalexamination
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findTechnicalexamination($id)
    {
        $entity = $this->getTechnicalexaminationRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Техническое освидетельствование не найдено');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findTechnicalexamination($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Техническое освидетельствование удалено');

        return $this->redirect($this->generateUrl('technicalexamination_list'));
    }
}
