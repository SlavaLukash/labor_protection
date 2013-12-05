<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sir\OtBundle\Entity\Traumacause;
use Sir\OtBundle\Form\TraumacauseType;
use Sir\OtBundle\Filter\TraumacauseFilterType;

/**
 * Traumacause controller.
 *
 */
class TraumacauseController extends Controller
{

    /**
     * Lists all Traumacause entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new TraumacauseFilterType());
		$form->bind($this->get('request'));
		$filterBuilder = $this->get('doctrine.orm.entity_manager')
			->getRepository('SirOtBundle:Traumacause')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery($filterBuilder->getDql());
		$paginator  = $this->get('knp_paginator');
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('SirOtBundle:Traumacause:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Traumacause entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Traumacause();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('traumacause_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Traumacause:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Traumacause entity.
    *
    * @param Traumacause $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Traumacause $entity)
    {
        $form = $this->createForm(new TraumacauseType(), $entity, array(
            'action' => $this->generateUrl('traumacause_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Traumacause entity.
     *
     */
    public function newAction()
    {
        $entity = new Traumacause();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Traumacause:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Traumacause entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Traumacause')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traumacause entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Traumacause:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Traumacause entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Traumacause')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traumacause entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Traumacause:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Traumacause entity.
    *
    * @param Traumacause $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Traumacause $entity)
    {
        $form = $this->createForm(new TraumacauseType(), $entity, array(
            'action' => $this->generateUrl('traumacause_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Traumacause entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Traumacause')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traumacause entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('traumacause_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Traumacause:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Traumacause entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Traumacause')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Traumacause entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('traumacause'));
    }

    /**
     * Creates a form to delete a Traumacause entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('traumacause_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
