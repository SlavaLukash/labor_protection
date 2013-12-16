<?php

namespace Sir\OtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TechnicalexaminationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resulttext')
//            ->add('plandate')
//            ->add('factdate')
			->add('plandate', 'date', array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			))
			->add('factdate', 'date', array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			))
            ->add('equipment')
            ->add('technicalexaminationkind')
            ->add('technicalexaminationcause')
            ->add('technicalexaminationtype')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sir\OtBundle\Entity\Technicalexamination'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sir_otbundle_technicalexamination';
    }
}
