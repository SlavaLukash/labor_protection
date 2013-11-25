<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sir\OtBundle\Entity\Medicalkind;
use Sir\OtBundle\Form\MedicalkindType;

/**
 * Medicalkind controller.
 *
 */
class MedicalkindController extends Controller
{

    /**
     * Lists all Medicalkind entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SirOtBundle:Medicalkind')->findAll();

        return $this->render('SirOtBundle:Medicalkind:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Medicalkind entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Medicalkind();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('medicalkind_show', array('id' => $entity->getId())));
        }

        return $this->render('SirOtBundle:Medicalkind:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Medicalkind entity.
    *
    * @param Medicalkind $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Medicalkind $entity)
    {
        $form = $this->createForm(new MedicalkindType(), $entity, array(
            'action' => $this->generateUrl('medicalkind_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Medicalkind entity.
     *
     */
    public function newAction()
    {
        $entity = new Medicalkind();
        $form   = $this->createCreateForm($entity);

        return $this->render('SirOtBundle:Medicalkind:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Medicalkind entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Medicalkind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicalkind entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Medicalkind:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Medicalkind entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Medicalkind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicalkind entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Medicalkind:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Medicalkind entity.
    *
    * @param Medicalkind $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Medicalkind $entity)
    {
        $form = $this->createForm(new MedicalkindType(), $entity, array(
            'action' => $this->generateUrl('medicalkind_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Medicalkind entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SirOtBundle:Medicalkind')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicalkind entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('medicalkind_edit', array('id' => $id)));
        }

        return $this->render('SirOtBundle:Medicalkind:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Medicalkind entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SirOtBundle:Medicalkind')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Medicalkind entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('medicalkind'));
    }

    /**
     * Creates a form to delete a Medicalkind entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medicalkind_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
