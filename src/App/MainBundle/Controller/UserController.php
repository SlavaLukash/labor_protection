<?php
namespace App\MainBundle\Controller;

use App\MainBundle\DBAL\Types\Roles;
use App\MainBundle\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * User controller.
 *
 */
class UserController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('user_list'));
    }

    public function listAction()
    {
        $builder = $this->createFormBuilder(null, [
            'csrf_protection' => false,
            'method' => 'get'
        ]);

        $this->buildFilterForm($builder);
        $form = $builder->getForm();
        $request = $this->get('request');
        $form->submit($request);

        $query = $this->createFilterQuery($form);
        $pagination = $this->paginate($query);

        return $this->render('MainBundle:User:list.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView()
        ]);
    }

    public function editAction($id = null)
    {
        $isNew = null === $id;

        if ($isNew) {
            $entity = new User();
        } else {
            $entity = $this->findUser($id);
        }

        $builder = $this->createFormBuilder($entity)
            ->add('username', null, [])
            ->add('email', null, [])
            ->add('plainPassword', null, [
                'required' => false,
                'label' => 'Password'
            ])
            ->add('roles', 'choice', [
                'choices' => Roles::getChoices(),
                'multiple' => true,
                'expanded' => true
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('enterprise', 'entity', array(
                'class' => 'MainBundle:Enterprise',
//                'expanded'=> true,
                'multiple' => true,
                'empty_value' => false,
                'label' => 'Предприятие',
                'constraints' => [
                    new NotBlank([])
                ],
                'attr' => ['class' => 'select2']
            ))
        ;

        $editForm = $builder->getForm();
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isNew) {
                $this->addFlashMessage('success', 'Пользователь создан');
            } else {
                $this->addFlashMessage('success', 'Пользователь сохранен');
            }

            return $this->redirect($this->generateUrl('user_edit', [
                'id' => $entity->getId()
            ]));
        }

        return $this->render('MainBundle:User:edit.html.twig', [
            'isNew' => $isNew,
            'entity' => $entity,
            'form'   => $editForm->createView(),
            'isNew' => $isNew
        ]);
    }

    protected function buildFilterForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('email', 'text', [
                'label' => 'Email',
                'required' => false
            ])
            ->add('submit', 'submit', [
                'label' => 'Применить'
            ])
        ;
    }

    protected function createFilterQuery(Form $form)
    {
        $qb = $this->getUserRepository()->createQueryBuilder('u');

        if ($form->get('email')->getNormData()) {
            $qb->andWhere('u.email LIKE :email');
            $qb->setParameter('email', '%' . $form->get('email')->getNormData() . '%');
        }

        if ($form->has('sort_field') && $form->get('sort_field')->getNormData()) {
            $qb->orderBy('u.' . $form->get('sort_field')->getNormData(), $form->get('sort_order')->getNormData());
        } else {
            $qb->orderBy('u.id', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return null|User
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findUser($id)
    {
        $entity = $this->getUserRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Пользователь не найден');
        }

        return $entity;
    }

    public function showAction()
    {
        return new Response();
    }

    public function removeAction($id)
    {
        $user = $this->findUser($id);

        if(!$user) {
            new NotFoundHttpException();
        }

        $em = $this->getEntityManager();
        $em->remove($user);
        $em->flush();

        $this->addFlashMessage('success', 'Пользователь удален');

        return $this->redirect($this->generateUrl('user_list'));
    }
}
