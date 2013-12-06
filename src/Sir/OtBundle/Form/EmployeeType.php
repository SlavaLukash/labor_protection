<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

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
			->add('subdivision', 'entity', array(
				'class' => 'SirOtBundle:Subdivision',
				'empty_value' => false,
				'choices' => $options['sdArray'],
			))
            ->add('marriagekind')
            ->add('profession')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
		$resolver->setRequired(array(
			'sdArray',
		));

        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\Employee',
			'sdArray' => null,
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
