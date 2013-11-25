<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sir\OtBundle\Entity\Equipmentsubgroup;
use Sir\OtBundle\Form\EquipmentsubgroupType;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SirOtBundle:Equipmentsubgroup')->findAll();

        return $this->render('SirOtBundle:Equipmentsubgroup:index.html.twig', array(
            'entities' => $entities,
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

        return $this->render('SirOtBundle:Equipmentsubgroup:new.html.twig', array(
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

        return $this->render('SirOtBundle:Equipmentsubgroup:new.html.twig', array(
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

        $entity = $em->getRepository('SirOtBundle:Equipmentsubgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentsubgroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Equipmentsubgroup:show.html.twig', array(
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

        $entity = $em->getRepository('SirOtBundle:Equipmentsubgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentsubgroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Equipmentsubgroup:edit.html.twig', array(
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

        $entity = $em->getRepository('SirOtBundle:Equipmentsubgroup')->find($id);

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

        return $this->render('SirOtBundle:Equipmentsubgroup:edit.html.twig', array(
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
            $entity = $em->getRepository('SirOtBundle:Equipmentsubgroup')->find($id);

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
