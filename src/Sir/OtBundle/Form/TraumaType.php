<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TraumaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datetrauma')
            ->add('traumareport')
            ->add('hoursstart')
            ->add('employee')
            ->add('traumacause')
            ->add('traumakind')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\Trauma'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sir_otbundle_trauma';
    }
}
