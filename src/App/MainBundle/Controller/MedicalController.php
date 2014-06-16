<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\MainBundle\Entity\Medical;
use App\MainBundle\Form\MedicalType;
use App\MainBundle\Filter\MedicalFilterType;

/**
 * Medical controller.
 *
 */
class MedicalController extends Controller
{

    /**
     * Lists all Medical entities.
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

		$form = $this->get('form.factory')->create(new MedicalFilterType($sdArray, $entArray));
		$form->bind($this->get('request'));
		$filterBuilder = $em
			->getRepository('MainBundle:Medical')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
		$query = $em->createQuery($filterBuilder->getDql());
		$paginator  = $this->get('knp_paginator');
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

		return $this->render('MainBundle:Medical:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Medical entity.
     *
     */
    public function createAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$aSubdivisions = $em->getRepository('MainBundle:Subdivision')->findAll();
		$aEnterprises = $em->getRepository('MainBundle:Enterprise')->findAll();
		$oUser = $this->getUser();
//		if(!$oUser->hasRole('ROLE_ADMIN')) {
//			$aSubdivisions = $oUser->getUsersubdivisions()->getValues();
//		}
//		foreach($aSubdivisions as $subdivision)
//		{
//			$OTparams['aEnterprise'][$subdivision->getEnterprise()->getId()] = $subdivision->getEnterprise();
//		}

//		$arRequest  = $request->request->all();

//		$employeeId = $arRequest['mainbundle_medical']['employee'];
//		$OTparams['aEmployee'][] = $em->getRepository('MainBundle:Employee')->find($employeeId);
//		$OTparams['aSubdivision'] = $aSubdivisions;
		$entity = new Medical();
		$form = $this->createCreateForm($entity/*, $OTparams*/);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('medical_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Medical:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Medical entity.
    *
    * @param Medical $entity The entity
	*
	* @param $OTparams
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Medical $entity/*, $OTparams = null*/)
    {
        $form = $this->createForm(new MedicalType(), $entity, array(
            'action' => $this->generateUrl('medical_create'),
            'method' => 'POST'/*,
			'OTparams' => $OTparams*/
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Medical entity.
     *
     */
    public function newAction()
    {
		$em = $this->getDoctrine()->getManager();
		$aSubdivisions = $em->getRepository('MainBundle:Subdivision')->findAll();
		$aEnterprises = $em->getRepository('MainBundle:Enterprise')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$aSubdivisions = $oUser->getUsersubdivisions()->getValues();
		}
		foreach($aSubdivisions as $subdivision)
		{
			$OTparams['aEnterprise'][$subdivision->getEnterprise()->getId()] = $subdivision->getEnterprise();
		}
		$OTparams['aSubdivision'] = array();
		$OTparams['aEmployee'] = array();
		$entity = new Medical();
		$form = $this->createCreateForm($entity, $OTparams);

        return $this->render('MainBundle:Medical:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Medical entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Medical')->find($id);

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
            throw $this->createNotFoundException('Unable to find Medical entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Medical:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Medical entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Medical')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medical entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Medical:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Medical entity.
    *
    * @param Medical $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Medical $entity)
    {
        $form = $this->createForm(new MedicalType(), $entity, array(
            'action' => $this->generateUrl('medical_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Medical entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Medical')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medical entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('medical_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Medical:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Medical entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Medical')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Medical entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('medical'));
    }

    /**
     * Creates a form to delete a Medical entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medical_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}