<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Report;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Report controller.
 *
 */
class ReportController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('report_list'));
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

        return $this->render('MainBundle:Report:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function categoryListAction($Categoryid = null)
    {
        $CategoryReportEntities = $this->getCategoryReportRepository()->findAll();

        if(!$Categoryid) {
            foreach($CategoryReportEntities as $item) {
                $Categoryid		= $item->getId();
                break;
            }
        }

        $entities = $this->getReportRepository()->findByCategoryreport($Categoryid);

        return $this->render('MainBundle:Report:category_list.html.twig', [
            'entities' 						=> $entities,
            'categoryid' 					=> $Categoryid,
            'CategoryReportEntities' 		=> $CategoryReportEntities
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new Report();
        } else {
            $entity = $this->findReport($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('name')
            ->add('params')
            ->add('categoryreport', null, [
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
                $this->addFlashMessage('success', 'Отчет создан');
            } else {
                $this->addFlashMessage('success', 'Отчет сохранен');
            }

            return $this->redirect($this->generateUrl('report_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:Report:edit.html.twig', [
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
        $qb = $this->getReportRepository()->createQueryBuilder('r');

        if ($form->get('name')->getNormData()) {
            $qb->andWhere('r.name LIKE :name');
            $qb->setParameter('name', '%' . $form->get('name')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('r.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|Report
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findReport($id)
    {
        $entity = $this->getReportRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Отчет не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $entity = $this->findReport($id);

        if(!$entity) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->addFlashMessage('success', 'Отчет удален');

        return $this->redirect($this->generateUrl('report_list'));
    }
}
