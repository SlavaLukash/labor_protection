<?php

namespace App\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

	protected $roles;
	protected $userRoles;
	protected $entity;

	public function __construct($entity, $roles, $userRoles) {
		foreach ($roles as $role) {
			$theRoles[$role] = $role;
		}

		$this->roles 		= $theRoles;
		$this->userRoles 	= $userRoles;
		$this->entity 		= $entity;
	}

    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled', null, array('required' => false))
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked', null, array('required' => false))
            ->add('expired', null, array('required' => false))
            ->add('expiresAt')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('roles')
			->add('usersubdivisions')
        ;
    }*/

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder ,$options);

		$builder
			->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
			->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
			->add('plainPassword', 'repeated', array(
				'required' => ($this->entity->getId()) ? false : true,
				'type' => 'password',
				'options' => array('translation_domain' => 'FOSUserBundle'),
				'first_options' => array('label' => 'form.password'),
				'second_options' => array('label' => 'form.password_confirmation'),
				'invalid_message' => 'fos_user.password.mismatch',
			))
			->add('enabled', null, array('required' => false))
			->add('roles', 'choice', array(
				'choices' => $this->roles,
				'data' => $this->userRoles,
				'expanded' => true,
				'multiple' => true,
			))
//			->add('usersubdivisions')
			->add('usersubdivisions', 'entity', array(
				'class' => 'MainBundle:Subdivision',
				'empty_value' => false,
				'choices' => $options['sdArray'],
				'expanded'  => false,
				'multiple'  => true
			))
		;
//		var_dump($options['sdArray']);die;
	}
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\MainBundle\Entity\User',
			'sdArray' => null,
        ));

		$resolver->setRequired(array(
			'sdArray',
		));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mainbundle_user';
    }
}
