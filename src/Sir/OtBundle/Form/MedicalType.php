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
            ->add('comment')
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
			->add('employee', 'choice', array(
				'label' => 'Предприятие',
				'attr' => array('class' => 'med_enterprise'),
				'empty_value' => '',
				'choices' => $options['OTparams']['aEnterprise'],
			))
            ->add('medicalkind', null, array(
				'empty_value' => false,
			))
            ->add('medicaltype', null, array(
				'empty_value' => false,
			))
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
