<?php

namespace App\MainBundle\Form;

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
//            ->add('datetrauma')
			->add('datetrauma', 'date', array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			))
            ->add('traumareport')
            ->add('hoursstart')
			->add('employee', 'entity', array(
				'class' => 'MainBundle:Employee',
				'empty_value' => false,
				'choices' => $options['OTparams']['aEmployee'],
			))
            ->add('traumacause')
            ->add('traumakind')
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
            'data_class' => 'App\MainBundle\Entity\Trauma',
			'OTparams' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mainbundle_trauma';
    }
}
