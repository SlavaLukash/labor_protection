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
            ->add('name')
            ->add('model')
            ->add('registrationnumber')
            ->add('internalnumber')
            ->add('factorynumber')
            ->add('manufacturer')
            ->add('productiondate')
            ->add('startupdate')
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
            'data_class' => 'Sir\OtBundle\Entity\Equipment'
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
