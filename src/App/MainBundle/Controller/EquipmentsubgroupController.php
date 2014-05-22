<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\MainBundle\Entity\Equipmentsubgroup;
use App\MainBundle\Form\EquipmentsubgroupType;
use App\MainBundle\Filter\EquipmentsubgroupFilterType;

/**
 * Equipmentsubgroup controller.
 *
 */
class EquipmentsubgroupController extends Controller
{

    /**
     * Lists all Equipmentsubgroup entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new EquipmentsubgroupFilterType());
		$form->bind($this->get('request'));
		$filterBuilder = $this->get('doctrine.orm.entity_manager')
			->getRepository('MainBundle:Equipmentsubgroup')
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

		return $this->render('MainBundle:Equipmentsubgroup:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Equipmentsubgroup entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Equipmentsubgroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('equipmentsubgroup_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Equipmentsubgroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Equipmentsubgroup entity.
    *
    * @param Equipmentsubgroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Equipmentsubgroup $entity)
    {
        $form = $this->createForm(new EquipmentsubgroupType(), $entity, array(
            'action' => $this->generateUrl('equipmentsubgroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Equipmentsubgroup entity.
     *
     */
    public function newAction()
    {
        $entity = new Equipmentsubgroup();
        $form   = $this->createCreateForm($entity);

        return $this->render('MainBundle:Equipmentsubgroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Equipmentsubgroup entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Equipmentsubgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentsubgroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Equipmentsubgroup:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Equipmentsubgroup entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Equipmentsubgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentsubgroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Equipmentsubgroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Equipmentsubgroup entity.
    *
    * @param Equipmentsubgroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Equipmentsubgroup $entity)
    {
        $form = $this->createForm(new EquipmentsubgroupType(), $entity, array(
            'action' => $this->generateUrl('equipmentsubgroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Equipmentsubgroup entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Equipmentsubgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentsubgroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('equipmentsubgroup_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Equipmentsubgroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Equipmentsubgroup entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Equipmentsubgroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Equipmentsubgroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('equipmentsubgroup'));
    }

    /**
     * Creates a form to delete a Equipmentsubgroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipmentsubgroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
