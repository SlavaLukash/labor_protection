<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sir\OtBundle\Entity\Equipment;
use Sir\OtBundle\Form\EquipmentType;
use Sir\OtBundle\Filter\EquipmentFilterType;

/**
 * Equipment controller.
 *
 */
class EquipmentController extends Controller
{

    /**
     * Lists all Equipment entities.
     *
     */
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$oUser = $this->getUser();
		$sdArray = $em->getRepository('SirOtBundle:Subdivision')->findAll();
		$entArray = $em->getRepository('SirOtBundle:Enterprise')->findAll();
		$aESubGroup = $em->getRepository('SirOtBundle:Equipmentsubgroup')->findAll();
		$aEGroup = $em->getRepository('SirOtBundle:Equipmentgroup')->findAll();
		if(!$oUser->hasRole('ROLE_ADMIN')) {
			$sdArray = $oUser->getUsersubdivisions()->getValues();
		}

		$form = $this->get('form.factory')->create(new EquipmentFilterType($sdArray, $entArray, $aESubGroup));
		$form->bind($this->get('request'));
		$filterBuilder = $em
			->getRepository('SirOtBundle:Equipment')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
		$query = $em->createQuery($filterBuilder->getDql());

		$paginator  = $this->get('knp_paginator');
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('SirOtBundle:Equipment:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Equipment entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Equipment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('equipment_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Equipment:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Equipment entity.
    *
    * @param Equipment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Equipment $entity)
    {
        $form = $this->createForm(new EquipmentType(), $entity, array(
            'action' => $this->generateUrl('equipment_create'),
            'method' => 'POST',
        ));

		$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Equipment entity.
     *
     */
    public function newAction()
    {
        $entity = new Equipment();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Equipment:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Equipment entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Equipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Equipment:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Equipment entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Equipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Equipment:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Equipment entity.
    *
    * @param Equipment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Equipment $entity)
    {
        $form = $this->createForm(new EquipmentType(), $entity, array(
            'action' => $this->generateUrl('equipment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Equipment entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Equipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('equipment_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Equipment:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Equipment entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Equipment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Equipment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('Equipment'));
    }

    /**
     * Creates a form to delete a Equipment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
