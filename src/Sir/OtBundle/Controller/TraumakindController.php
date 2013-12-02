<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sir\OtBundle\Entity\Traumakind;
use Sir\OtBundle\Form\TraumakindType;
use Sir\OtBundle\Filter\TraumakindFilterType;

/**
 * Traumakind controller.
 *
 */
class TraumakindController extends Controller
{

    /**
     * Lists all Traumakind entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new TraumakindFilterType());
		if ($this->get('request')->query->has('submit-filter')) {
			$form->bind($this->get('request'));

			$filterBuilder = $this->get('doctrine.orm.entity_manager')
				->getRepository('SirOtBundle:Traumakind')
				->createQueryBuilder('e');

			$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery($filterBuilder->getDql());
			$entities = $query->getResult();
		} else {
			$em = $this->getDoctrine()->getManager();
			$entities = $em->getRepository('SirOtBundle:Traumakind')->findAll();
		}

		return $this->render('SirOtBundle:Traumakind:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Traumakind entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Traumakind();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('traumakind_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Traumakind:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Traumakind entity.
    *
    * @param Traumakind $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Traumakind $entity)
    {
        $form = $this->createForm(new TraumakindType(), $entity, array(
            'action' => $this->generateUrl('traumakind_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Traumakind entity.
     *
     */
    public function newAction()
    {
        $entity = new Traumakind();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Traumakind:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Traumakind entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Traumakind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traumakind entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Traumakind:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Traumakind entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Traumakind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traumakind entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Traumakind:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Traumakind entity.
    *
    * @param Traumakind $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Traumakind $entity)
    {
        $form = $this->createForm(new TraumakindType(), $entity, array(
            'action' => $this->generateUrl('traumakind_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Traumakind entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Traumakind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traumakind entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('traumakind_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Traumakind:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Traumakind entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Traumakind')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Traumakind entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('traumakind'));
    }

    /**
     * Creates a form to delete a Traumakind entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('traumakind_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
