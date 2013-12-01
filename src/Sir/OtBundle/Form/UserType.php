<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
//            ->add('usernameCanonical')
            ->add('email')
//            ->add('emailCanonical')
            ->add('enabled', null, array('required' => false))
//            ->add('salt')
            ->add('password')
//            ->add('lastLogin')
            ->add('locked', null, array('required' => false))
            ->add('expired', null, array('required' => false))
            ->add('expiresAt')
//            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
//            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')
            ->add('roles')
			->add('usersubdivisions')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sir_otbundle_user';
    }
}
