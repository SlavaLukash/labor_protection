<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Employee;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Employee controller.
 *
 */
class EmployeeController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('employee_list'));
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

        return $this->render('MainBundle:Employee:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Employee();
        } else {
            $entity = $this->findEmployee($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('lastname', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank([])
                ]
            ])
            ->add('firstname', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank([])
                ]
            ])
            ->add('middlename', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank([])
                ]
            ])
            ->add('sex', 'choice', array(
                'choices' => array('Ж', 'М')
            ))
            ->add('bithday', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input'),
                'required' => false,
            ))
            ->add('date_first_medical', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input'),
                'required' => false,
            ))
            ->add('date_instruction', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'date-input'),
                'required' => false,
            ))
            ->add('subdivision', 'entity', array(
                'class' => 'MainBundle:Subdivision',
                'empty_value' => false,
                'label' => 'Предприятие и подразделение',
                'constraints' => [
                    new NotBlank([])
                ]
//                'choices' => $options['sdArray'],
            ))
            ->add('marriagekind')
//            ->add('profession')
            /*->add('profession', 'genemu_jqueryselect2_hidden', [
                'data_class' => 'App\MainBundle\Entity\Profession',
                'mapped' => true,
                'attr' => [
                    'class' => 'bigdrop'
                ]
            ])*/
            ->add('profession', 'genemu_jqueryselect2_entity', [
                'class' => 'App\MainBundle\Entity\Profession',
                'property' => 'name',
                'required' => true,
                'constraints' => [
                    new NotBlank([])
                ],
                'configs' => [
                    'minimumInputLength' => 3,
                    'placeholder' => 'Votre ville',
                    'allowClear' => true,
                    'width' => '420px'
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
                $this->addFlashMessage('success', 'Сотрудник создан');
            } else {
                $this->addFlashMessage('success', 'Сотрудник сохранен');
            }

            return $this->redirect($this->generateUrl('employee_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Employee:edit.html.twig', [
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
        $qb = $this->getEmployeeRepository()->createQueryBuilder('e');

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
     * @return null|Employee
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findEmployee($id)
    {
        $entity = $this->getEmployeeRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Сотрудник не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findEmployee($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Сотрудник удален');

        return $this->redirect($this->generateUrl('employee_list'));
    }
}
