<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\MainBundle\Entity\Employee;
use App\MainBundle\Form\EmployeeType;
use App\MainBundle\Filter\EmployeeFilterType;

/**
 * Employee controller.
 *
 */
class EmployeeController extends Controller
{

    /**
     * Lists all Employee entities.
     *
     */
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$oUser = $this->getUser();
		$sdArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$entArray = $em->getRepository('MainBundle:Enterprise')->findAll();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = $oUser->getUsersubdivisions()->getValues();
		}

		$form = $this->get('form.factory')->create(new EmployeeFilterType($sdArray, $entArray));
		$form->bind($this->get('request'));
		$filterBuilder = $em
			->getRepository('MainBundle:Employee')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
		$query = $em->createQuery($filterBuilder->getDql());

		$paginator  = $this->get('knp_paginator');
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('MainBundle:Employee:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Employee entity.
     *
     */
    public function createAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$sdArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$entArray = $em->getRepository('MainBundle:Enterprise')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = $oUser->getUsersubdivisions()->getValues();
		}
		$entity = new Employee();

		$form   = $this->createCreateForm($entity, $sdArray);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('employee_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Employee:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Employee entity.
    *
    * @param Employee $entity The entity
    *
	* @param $sdArray
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Employee $entity, $sdArray = null)
    {
        $form = $this->createForm(new EmployeeType(), $entity, array(
            'action' => $this->generateUrl('employee_create'),
            'method' => 'POST',
			'sdArray' => $sdArray
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Employee entity.
     *
     */
    public function newAction()
    {
		$em = $this->getDoctrine()->getManager();
		$sddArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$entArray = $em->getRepository('MainBundle:Enterprise')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = array();
			foreach($oUser->getUsersubdivisions()->getValues() as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		} else {
			$sdArray = array();
			foreach($sddArray as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		}
        $entity = new Employee();

        $form   = $this->createCreateForm($entity, $sdArray);
        return $this->render('MainBundle:Employee:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Employee entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Employee')->find($id);

		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = $oUser->getUsersubdivisions()->getValues();
			foreach($sdArray as $subD)
			{
				$aIds[] = $subD->getId();
			}
			if(!in_array($entity->getSubdivision()->getId(),$aIds))
			{
				return $this->redirect($this->generateUrl('employee'));
			}
		}

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Employee:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Employee entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
		$sddArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$entArray = $em->getRepository('MainBundle:Enterprise')->findAll();
        $entity = $em->getRepository('MainBundle:Employee')->find($id);

		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = array();
			foreach($oUser->getUsersubdivisions()->getValues() as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		} else {
			$sdArray = array();
			foreach($sddArray as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		}

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $editForm = $this->createEditForm($entity, $sdArray);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Employee:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Employee entity.
    *
    * @param Employee $entity The entity
    *
    * @param sdArray
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Employee $entity, $sdArray = null)
    {
        $form = $this->createForm(new EmployeeType(), $entity, array(
            'action' => $this->generateUrl('employee_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'sdArray' => $sdArray,
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Employee entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Employee')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('employee_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Employee:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Employee entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Employee')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Employee entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('employee'));
    }

    /**
     * Creates a form to delete a Employee entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employee_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
