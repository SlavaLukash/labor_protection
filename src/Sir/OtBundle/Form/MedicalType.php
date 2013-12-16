<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
//            ->add('dateplan')
//            ->add('datefact')
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
			->add('employee', 'entity', array(
				'class' => 'SirOtBundle:Employee',
				'empty_value' => false,
				'choices' => $options['OTparams']['aEmployee'],
			))
            ->add('medicalkind')
            ->add('medicaltype')
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
