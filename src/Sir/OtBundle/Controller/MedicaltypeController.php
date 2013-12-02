<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sir\OtBundle\Entity\Medicaltype;
use Sir\OtBundle\Form\MedicaltypeType;
use Sir\OtBundle\Filter\MedicaltypeFilterType;

/**
 * Medicaltype controller.
 *
 */
class MedicaltypeController extends Controller
{

    /**
     * Lists all Medicaltype entities.
     *
     */
    public function indexAction()
    {
		$form = $this->get('form.factory')->create(new MedicaltypeFilterType());
		if ($this->get('request')->query->has('submit-filter')) {
			$form->bind($this->get('request'));

			$filterBuilder = $this->get('doctrine.orm.entity_manager')
				->getRepository('SirOtBundle:Medicaltype')
				->createQueryBuilder('e');

			$this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery($filterBuilder->getDql());
			$entities = $query->getResult();
		} else {
			$em = $this->getDoctrine()->getManager();
			$entities = $em->getRepository('SirOtBundle:Medicaltype')->findAll();
		}

		return $this->render('SirOtBundle:Medicaltype:index.html.twig', array(
			'entities' => $entities,
			'form' => $form->createView(),
		));
    }
    /**
     * Creates a new Medicaltype entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Medicaltype();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('medicaltype_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Medicaltype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Medicaltype entity.
    *
    * @param Medicaltype $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Medicaltype $entity)
    {
        $form = $this->createForm(new MedicaltypeType(), $entity, array(
            'action' => $this->generateUrl('medicaltype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Medicaltype entity.
     *
     */
    public function newAction()
    {
        $entity = new Medicaltype();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Medicaltype:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Medicaltype entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Medicaltype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicaltype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Medicaltype:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Medicaltype entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Medicaltype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicaltype entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Medicaltype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Medicaltype entity.
    *
    * @param Medicaltype $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Medicaltype $entity)
    {
        $form = $this->createForm(new MedicaltypeType(), $entity, array(
            'action' => $this->generateUrl('medicaltype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Medicaltype entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Medicaltype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicaltype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('medicaltype_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Medicaltype:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Medicaltype entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Medicaltype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Medicaltype entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('medicaltype'));
    }

    /**
     * Creates a form to delete a Medicaltype entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medicaltype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
