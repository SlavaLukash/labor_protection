<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\MainBundle\Entity\Technicalexaminationkind;
use App\MainBundle\Form\TechnicalexaminationkindType;
use App\MainBundle\Filter\TechnicalexaminationkindFilterType;

/**
 * Technicalexaminationkind controller.
 *
 */
class TechnicalexaminationkindController extends Controller
{

    /**
     * Lists all Technicalexaminationkind entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new TechnicalexaminationkindFilterType());
		$form->bind($this->get('request'));
		$filterBuilder = $this->get('doctrine.orm.entity_manager')
			->getRepository('MainBundle:Technicalexaminationkind')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        $em = $this->getDoctrine()->getManager();

		$query = $em->createQuery($filterBuilder->getDql());
		$paginator  = $this->get('knp_paginator');

//        $entities = $em->getRepository('MainBundle:Technicalexaminationkind')->findAll();
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

        return $this->render('MainBundle:Technicalexaminationkind:index.html.twig', array(
            'entities' => $entities,
			'form' => $form->createView(),
        ));
    }
    /**
     * Creates a new Technicalexaminationkind entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Technicalexaminationkind();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexaminationkind_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Technicalexaminationkind:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Technicalexaminationkind entity.
    *
    * @param Technicalexaminationkind $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Technicalexaminationkind $entity)
    {
        $form = $this->createForm(new TechnicalexaminationkindType(), $entity, array(
            'action' => $this->generateUrl('technicalexaminationkind_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Technicalexaminationkind entity.
     *
     */
    public function newAction()
    {
        $entity = new Technicalexaminationkind();
        $form   = $this->createCreateForm($entity);

        return $this->render('MainBundle:Technicalexaminationkind:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Technicalexaminationkind entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationkind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationkind entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexaminationkind:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Technicalexaminationkind entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationkind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationkind entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexaminationkind:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Technicalexaminationkind entity.
    *
    * @param Technicalexaminationkind $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Technicalexaminationkind $entity)
    {
        $form = $this->createForm(new TechnicalexaminationkindType(), $entity, array(
            'action' => $this->generateUrl('technicalexaminationkind_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Technicalexaminationkind entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationkind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationkind entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexaminationkind_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Technicalexaminationkind:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Technicalexaminationkind entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Technicalexaminationkind')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Technicalexaminationkind entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('technicalexaminationkind'));
    }

    /**
     * Creates a form to delete a Technicalexaminationkind entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('technicalexaminationkind_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
