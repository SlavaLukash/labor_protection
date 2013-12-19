<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class MedicalType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('enterprise', 'entity', array(
				'class' => 'SirOtBundle:Enterprise',
				'mapped' => false,
				'attr' => array('class' => 'med_enterprise'),
				'choices' => $options['OTparams']['aEnterprise'],
			))
			->add('subdivision', 'entity', array(
				'class' => 'SirOtBundle:Subdivision',
				'mapped' => false,
				'attr' => array('class' => 'med_subdivision'),
				'choices' => $options['OTparams']['aSubdivision'],
			))
			->add('employee', 'entity', array(
				'class' => 'SirOtBundle:Employee',
				'attr' => array('class' => 'med_employee'),
				'choices' => $options['OTparams']['aEmployee'],
			))
			->add('medicalkind', null, array(
				'empty_value' => false,
			))
			->add('medicaltype', null, array(
				'empty_value' => false,
			))
			->add('dateplan', 'date', array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			))
			->add('datefact', 'date', array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			))
			->add('comment')
        ;
    }

    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
		$resolver->setRequired(array(
			'OTparams',
		));
        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\Medical',
			'OTparams' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sir_otbundle_medical';
    }
}
