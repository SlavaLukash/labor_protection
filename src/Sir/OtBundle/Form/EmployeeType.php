<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('middlename')
            ->add('sex', 'choice', array(
				'choices' => array('Ж', 'М')
			))
            ->add('bithday', 'date', array(
				'years' => range(1900, date('Y')
			)))
            ->add('date_first_medical', 'date', array(
				'years' => range(1900, date('Y')
				)))
            ->add('date_instruction', 'date', array(
				'years' => range(1900, date('Y')
				)))
            ->add('subdivision')
            ->add('marriagekind')
            ->add('profession')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\Employee'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sir_otbundle_employee';
    }
}
