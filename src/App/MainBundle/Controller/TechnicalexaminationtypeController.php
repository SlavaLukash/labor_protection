<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\MainBundle\Entity\Technicalexaminationtype;
use App\MainBundle\Form\TechnicalexaminationtypeType;
use App\MainBundle\Filter\TechnicalexaminationtypeFilterType;

/**
 * Technicalexaminationtype controller.
 *
 */
class TechnicalexaminationtypeController extends Controller
{

    /**
     * Lists all Technicalexaminationtype entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new TechnicalexaminationtypeFilterType());
		$form->bind($this->get('request'));
		$filterBuilder = $this->get('doctrine.orm.entity_manager')
			->getRepository('MainBundle:Technicalexaminationtype')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        $em = $this->getDoctrine()->getManager();

		$query = $em->createQuery($filterBuilder->getDql());
		$paginator  = $this->get('knp_paginator');
//        $entities = $em->getRepository('MainBundle:Technicalexaminationtype')->findAll();
		$entities = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1)/*page number*/,
			10/*limit per page*/
		);

        return $this->render('MainBundle:Technicalexaminationtype:index.html.twig', array(
            'entities' => $entities,
			'form' => $form->createView(),
        ));
    }
    /**
     * Creates a new Technicalexaminationtype entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Technicalexaminationtype();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexaminationtype_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Technicalexaminationtype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Technicalexaminationtype entity.
    *
    * @param Technicalexaminationtype $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Technicalexaminationtype $entity)
    {
        $form = $this->createForm(new TechnicalexaminationtypeType(), $entity, array(
            'action' => $this->generateUrl('technicalexaminationtype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Technicalexaminationtype entity.
     *
     */
    public function newAction()
    {
        $entity = new Technicalexaminationtype();
        $form   = $this->createCreateForm($entity);

        return $this->render('MainBundle:Technicalexaminationtype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Technicalexaminationtype entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationtype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexaminationtype:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Technicalexaminationtype entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationtype entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexaminationtype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Technicalexaminationtype entity.
    *
    * @param Technicalexaminationtype $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Technicalexaminationtype $entity)
    {
        $form = $this->createForm(new TechnicalexaminationtypeType(), $entity, array(
            'action' => $this->generateUrl('technicalexaminationtype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Technicalexaminationtype entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexaminationtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationtype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexaminationtype_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Technicalexaminationtype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Technicalexaminationtype entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Technicalexaminationtype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Technicalexaminationtype entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('technicalexaminationtype'));
    }

    /**
     * Creates a form to delete a Technicalexaminationtype entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('technicalexaminationtype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
