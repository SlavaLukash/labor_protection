<?php

namespace Sir\OtBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sir\OtBundle\Entity\Technicalexaminationtype;
use Sir\OtBundle\Form\TechnicalexaminationtypeType;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SirOtBundle:Technicalexaminationtype')->findAll();

        return $this->render('SirOtBundle:Technicalexaminationtype:index.html.twig', array(
            'entities' => $entities,
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

        return $this->render('SirOtBundle:Technicalexaminationtype:new.html.twig', array(
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

        return $this->render('SirOtBundle:Technicalexaminationtype:new.html.twig', array(
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

        $entity = $em->getRepository('SirOtBundle:Technicalexaminationtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationtype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Technicalexaminationtype:show.html.twig', array(
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

        $entity = $em->getRepository('SirOtBundle:Technicalexaminationtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexaminationtype entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SirOtBundle:Technicalexaminationtype:edit.html.twig', array(
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

        $entity = $em->getRepository('SirOtBundle:Technicalexaminationtype')->find($id);

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

        return $this->render('SirOtBundle:Technicalexaminationtype:edit.html.twig', array(
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
            $entity = $em->getRepository('SirOtBundle:Technicalexaminationtype')->find($id);

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
