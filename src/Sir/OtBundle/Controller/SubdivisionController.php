<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sir\OtBundle\Entity\Subdivision;
use Sir\OtBundle\Form\SubdivisionType;
use Sir\OtBundle\Filter\SubdivisionFilterType;

/**
 * Subdivision controller.
 *
 */
class SubdivisionController extends Controller
{

    /**
     * Lists all Subdivision entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new SubdivisionFilterType());
		if ($this->get('request')->query->has('submit-filter')) {
			$form->bind($this->get('request'));

			$filterBuilder = $this->get('doctrine.orm.entity_manager')
				->getRepository('SirOtBundle:Subdivision')
				->createQueryBuilder('e');

			$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

			$em = $this->getDoctrine()->getManager();
			var_dump($filterBuilder->getDql());
			$query = $em->createQuery($filterBuilder->getDql());
			$entities = $query->getResult();
		} else {
			$em = $this->getDoctrine()->getManager();
			$entities = $em->getRepository('SirOtBundle:Subdivision')->findAll();
		}

		return $this->render('SirOtBundle:Subdivision:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));


    }
    /**
     * Creates a new Subdivision entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Subdivision();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subdivision_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Subdivision:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Subdivision entity.
    *
    * @param Subdivision $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Subdivision $entity)
    {
        $form = $this->createForm(new SubdivisionType(), $entity, array(
            'action' => $this->generateUrl('subdivision_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Subdivision entity.
     *
     */
    public function newAction()
    {
        $entity = new Subdivision();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Subdivision:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Subdivision entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Subdivision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subdivision entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Subdivision:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Subdivision entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Subdivision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subdivision entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Subdivision:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Subdivision entity.
    *
    * @param Subdivision $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Subdivision $entity)
    {
        $form = $this->createForm(new SubdivisionType(), $entity, array(
            'action' => $this->generateUrl('subdivision_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Subdivision entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Subdivision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subdivision entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('subdivision_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Subdivision:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Subdivision entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Subdivision')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Subdivision entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subdivision'));
    }

    /**
     * Creates a form to delete a Subdivision entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subdivision_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
