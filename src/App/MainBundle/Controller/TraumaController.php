<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\MainBundle\Entity\Trauma;
use App\MainBundle\Form\TraumaType;
use App\MainBundle\Filter\TraumaFilterType;

/**
 * Trauma controller.
 *
 */
class TraumaController extends Controller
{

    /**
     * Lists all Trauma entities.
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

		$form = $this->get('form.factory')->create(new TraumaFilterType($sdArray, $entArray));
		$form->bind($this->get('request'));
		$filterBuilder = $em
			->getRepository('MainBundle:Trauma')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
		$query = $em->createQuery($filterBuilder->getDql());
		$paginator  = $this->get('knp_paginator');
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('MainBundle:Trauma:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Trauma entity.
     *
     */
    public function createAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$aSubdivisions = $em->getRepository('MainBundle:Subdivision')->findAll();
		$aEnterprises = $em->getRepository('MainBundle:Enterprise')->findAll();
		$aEmployee = $em->getRepository('MainBundle:Employee')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$aSubdivisions = $oUser->getUsersubdivisions()->getValues();
		}
		foreach($aSubdivisions as $subdivision)
		{
			$aSubdIds[] = $subdivision->getId();
		}
		foreach($aEmployee as $employee)
		{
			if(in_array($employee->getSubdivision()->getId(), $aSubdIds))
			{
				$OTparams['aEmployee'][$employee->getSubdivision()->getEnterprise()->getName()]['..' . $employee->getSubdivision()->getName()][] = $employee;
			}
		}
		$entity = new Trauma();
		$form = $this->createCreateForm($entity, $OTparams);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trauma_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Trauma:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Trauma entity.
    *
    * @param Trauma $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Trauma $entity, $OTparams = null)
    {
        $form = $this->createForm(new TraumaType(), $entity, array(
            'action' => $this->generateUrl('trauma_create'),
            'method' => 'POST',
			'OTparams' => $OTparams
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Trauma entity.
     *
     */
    public function newAction()
    {
		$em = $this->getDoctrine()->getManager();
		$aSubdivisions = $em->getRepository('MainBundle:Subdivision')->findAll();
		$aEnterprises = $em->getRepository('MainBundle:Enterprise')->findAll();
		$aEmployee = $em->getRepository('MainBundle:Employee')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$aSubdivisions = $oUser->getUsersubdivisions()->getValues();
		}
		foreach($aSubdivisions as $subdivision)
		{
			$aSubdIds[] = $subdivision->getId();
		}
		foreach($aEmployee as $employee)
		{
			if(in_array($employee->getSubdivision()->getId(), $aSubdIds))
			{
				$OTparams['aEmployee'][$employee->getSubdivision()->getEnterprise()->getName()]['..' . $employee->getSubdivision()->getName()][] = $employee;
			}
		}
		$entity = new Trauma();
		$form = $this->createCreateForm($entity, $OTparams);

        return $this->render('MainBundle:Trauma:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Trauma entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Trauma')->find($id);
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = $oUser->getUsersubdivisions()->getValues();
			foreach($sdArray as $subD)
			{
				$aIds[] = $subD->getId();
			}
			if(!in_array($entity->getEmployee()->getSubdivision()->getId(),$aIds))
			{
				return $this->redirect($this->generateUrl('medical'));
			}
		}
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trauma entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Trauma:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Trauma entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Trauma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trauma entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Trauma:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Trauma entity.
    *
    * @param Trauma $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Trauma $entity)
    {
        $form = $this->createForm(new TraumaType(), $entity, array(
            'action' => $this->generateUrl('trauma_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Trauma entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Trauma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trauma entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('trauma_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Trauma:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Trauma entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Trauma')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Trauma entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trauma'));
    }

    /**
     * Creates a form to delete a Trauma entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trauma_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
