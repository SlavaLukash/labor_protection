<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipmentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => true))
            ->add('model', null, array('required' => true))
            ->add('registrationnumber')
            ->add('internalnumber')
            ->add('factorynumber')
            ->add('manufacturer')
//            ->add('productiondate')
//            ->add('startupdate')
			->add('productiondate', 'date', array(
				'widget' => 'single_text'
			))
			->add('startupdate', 'date', array(
				'widget' => 'single_text'
			))
            ->add('life')
            ->add('equipmentsubgroup')
            ->add('subdivision')
            ->add('registrationtype')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\Equipment',
			'required' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sir_otbundle_equipment';
    }
}
