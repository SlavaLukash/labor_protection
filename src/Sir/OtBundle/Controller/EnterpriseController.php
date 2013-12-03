<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sir\OtBundle\Entity\Enterprise;
use Sir\OtBundle\Form\EnterpriseType;
use Sir\OtBundle\Filter\EnterpriseFilterType;

/**
 * Enterprise controller.
 *
 */
class EnterpriseController extends Controller
{

    /**
     * Lists all Enterprise entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new EnterpriseFilterType());
		$form->bind($this->get('request'));
		$filterBuilder = $this->get('doctrine.orm.entity_manager')
			->getRepository('SirOtBundle:Enterprise')
			->createQueryBuilder('e');
		$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery($filterBuilder->getDql());
		$entities = $query->getResult();

        return $this->render('SirOtBundle:Enterprise:index.html.twig', array(
            'entities' => $entities,
			'form' => $form->createView(),
        ));
    }
    /**
     * Creates a new Enterprise entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Enterprise();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('enterprise_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Enterprise:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Enterprise entity.
    *
    * @param Enterprise $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Enterprise $entity)
    {
        $form = $this->createForm(new EnterpriseType(), $entity, array(
            'action' => $this->generateUrl('enterprise_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Enterprise entity.
     *
     */
    public function newAction()
    {
        $entity = new Enterprise();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Enterprise:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Enterprise entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Enterprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enterprise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Enterprise:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Enterprise entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Enterprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enterprise entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Enterprise:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Enterprise entity.
    *
    * @param Enterprise $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Enterprise $entity)
    {
        $form = $this->createForm(new EnterpriseType(), $entity, array(
            'action' => $this->generateUrl('enterprise_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Enterprise entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Enterprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Enterprise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('enterprise_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Enterprise:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Enterprise entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Enterprise')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Enterprise entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('enterprise'));
    }

    /**
     * Creates a form to delete a Enterprise entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enterprise_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
