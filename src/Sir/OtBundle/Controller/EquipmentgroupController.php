<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sir\OtBundle\Entity\Equipmentgroup;
use Sir\OtBundle\Form\EquipmentgroupType;

/**
 * Equipmentgroup controller.
 *
 */
class EquipmentgroupController extends Controller
{

    /**
     * Lists all Equipmentgroup entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SirOtBundle:Equipmentgroup')->findAll();

        return $this->render('SirOtBundle:Equipmentgroup:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Equipmentgroup entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Equipmentgroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('equipmentgroup_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Equipmentgroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Equipmentgroup entity.
    *
    * @param Equipmentgroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Equipmentgroup $entity)
    {
        $form = $this->createForm(new EquipmentgroupType(), $entity, array(
            'action' => $this->generateUrl('equipmentgroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Equipmentgroup entity.
     *
     */
    public function newAction()
    {
        $entity = new Equipmentgroup();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Equipmentgroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Equipmentgroup entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Equipmentgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentgroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Equipmentgroup:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Equipmentgroup entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Equipmentgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentgroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Equipmentgroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Equipmentgroup entity.
    *
    * @param Equipmentgroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Equipmentgroup $entity)
    {
        $form = $this->createForm(new EquipmentgroupType(), $entity, array(
            'action' => $this->generateUrl('equipmentgroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Equipmentgroup entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Equipmentgroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipmentgroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('equipmentgroup_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Equipmentgroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Equipmentgroup entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Equipmentgroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Equipmentgroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('equipmentgroup'));
    }

    /**
     * Creates a form to delete a Equipmentgroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipmentgroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
