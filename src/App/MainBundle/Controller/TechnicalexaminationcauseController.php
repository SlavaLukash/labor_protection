<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\MainBundle\Entity\Technicalexaminationcause;
use App\MainBundle\Form\TechnicalexaminationcauseType;
use App\MainBundle\Filter\TechnicalexaminationcauseFilterType;

/**
 * Technicalexaminationcause controller.
 *
 */
class TechnicalexaminationcauseController extends Controller
{

    /**
     * Lists all Technicalexaminationcause entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new TechnicalexaminationcauseFilterType());
		$form->bind($this->get('request'));
		$filterBuilder = $this->get('doctrine.orm.entity_manager')
			->getRepository('MainBundle:Technicalexaminationcause')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        $em = $this->getDoctrine()->getManager();

		$query = $em->createQuery($filterBuilder->getDql());
		$paginator  = $this->get('knp_paginator');
//        $entities = $em->getRepository('MainBundle:Technicalexaminationcause')->findAll();
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

        return $this->render('MainBundle:Technicalexaminationcause:index.html.twig', array(
            'entities' => $entities,
			'form' => $form->createView(),
        ));
    }
    /**
     * Creates a new Technicalexaminationcause entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Technicalexaminationcause();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexaminationcause_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Technicalexaminationcause:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Technicalexaminationcause entity.
    *
    * @param Technicalexaminationcause $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Technicalexaminationcause $entity)
    {
        $form = $this->createForm(new TechnicalexaminationcauseType(), $entity, array(
            'action' => $this->generateUrl('technicalexaminationcause_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Technicalexaminationcause entity.
     *
     */
    public function newAction()
    {
        $entity = new Technicalexaminationcause();
        $form   = $this->createCreateForm($entity);

        return $this->render('MainBundle:Technicalexaminationcause:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Technicalexaminationcause entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationcause')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationcause entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexaminationcause:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Technicalexaminationcause entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationcause')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationcause entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexaminationcause:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Technicalexaminationcause entity.
    *
    * @param Technicalexaminationcause $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Technicalexaminationcause $entity)
    {
        $form = $this->createForm(new TechnicalexaminationcauseType(), $entity, array(
            'action' => $this->generateUrl('technicalexaminationcause_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Technicalexaminationcause entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationcause')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationcause entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexaminationcause_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Technicalexaminationcause:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Technicalexaminationcause entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Technicalexaminationcause')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Technicalexaminationcause entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('technicalexaminationcause'));
    }

    /**
     * Creates a form to delete a Technicalexaminationcause entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('technicalexaminationcause_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
