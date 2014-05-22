<?php

namespace App\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\MainBundle\Entity\User;
use App\MainBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MainBundle:User')->findAll();

        return $this->render('MainBundle:User:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();

		$em = $this->getDoctrine()->getManager();
		$sdArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN')) {
			$sdArray = $oUser->getUsersubdivisions()->getValues();
		}

        $form = $this->createCreateForm($entity, $sdArray);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return $this->render('MainBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(User $entity, $sdArray)
    {
		$roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
		$roles = array_keys($roleHierarchy);

//        $form = $this->createForm(new UserType('App\MainBundle\Entity\User', 'asdf'), $entity, array(
        $form = $this->createForm(new UserType($entity, $roles, $entity->getRoles()), $entity, array(
			'sdArray' => $sdArray,
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();

		$em = $this->getDoctrine()->getManager();
		$sddArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$entArray = $em->getRepository('MainBundle:Enterprise')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = array();
			foreach($oUser->getUsersubdivisions()->getValues() as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		} else {
			$sdArray = array();
			foreach($sddArray as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		}

        $form   = $this->createCreateForm($entity, $sdArray);

        return $this->render('MainBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:User')->find($id);

		$sddArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = array();
			foreach($oUser->getUsersubdivisions()->getValues() as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		} else {
			$sdArray = array();
			foreach($sddArray as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		}


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity, $sdArray);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MainBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity, $sdArray)
    {
		$roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
		$roles = array_keys($roleHierarchy);

        $form = $this->createForm(new UserType($entity, $roles, $entity->getRoles()), $entity, array(
			'sdArray'		=> $sdArray,
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MainBundle:User')->find($id);

		$sddArray = $em->getRepository('MainBundle:Subdivision')->findAll();
		$oUser = $this->getUser();
		if(!$oUser->hasRole('ROLE_ADMIN'))
		{
			$sdArray = array();
			foreach($oUser->getUsersubdivisions()->getValues() as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		} else {
			$sdArray = array();
			foreach($sddArray as $val)
			{
				$sdArray[$val->getEnterprise()->getName()][$val->getId()] = $val;
			}
		}

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $sdArray);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return $this->render('MainBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MainBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
