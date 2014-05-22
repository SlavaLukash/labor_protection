<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\MainBundle\Entity\Technicalexamination;
use App\MainBundle\Form\TechnicalexaminationType;

/**
 * Technicalexamination controller.
 *
 */
class TechnicalexaminationController extends Controller
{

    /**
     * Lists all Technicalexamination entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MainBundle:Technicalexamination')->findAll();

        return $this->render('MainBundle:Technicalexamination:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Technicalexamination entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Technicalexamination();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexamination_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:Technicalexamination:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Technicalexamination entity.
    *
    * @param Technicalexamination $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Technicalexamination $entity)
    {
        $form = $this->createForm(new TechnicalexaminationType(), $entity, array(
            'action' => $this->generateUrl('technicalexamination_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Technicalexamination entity.
     *
     */
    public function newAction()
    {
        $entity = new Technicalexamination();
        $form   = $this->createCreateForm($entity);

        return $this->render('MainBundle:Technicalexamination:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Technicalexamination entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexamination')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexamination entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexamination:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Technicalexamination entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexamination')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexamination entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:Technicalexamination:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Technicalexamination entity.
    *
    * @param Technicalexamination $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Technicalexamination $entity)
    {
        $form = $this->createForm(new TechnicalexaminationType(), $entity, array(
            'action' => $this->generateUrl('technicalexamination_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Technicalexamination entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:Technicalexamination')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technicalexamination entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('technicalexamination_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:Technicalexamination:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Technicalexamination entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:Technicalexamination')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Technicalexamination entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('technicalexamination'));
    }

    /**
     * Creates a form to delete a Technicalexamination entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('technicalexamination_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
