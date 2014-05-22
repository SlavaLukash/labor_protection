<?php

namespace App\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpenseType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$ch = range(1970, date('Y'));
		$newCh = array();
		foreach($ch as $c)
		{
			$newCh[$c] = $c;
		}
        $builder
			->add('enterprise')
            ->add('year', 'choice', array(
				'choices' => $newCh
			))
			->add('expensekind')
            ->add('sum1')
            ->add('sum2')
            ->add('sum3')
            ->add('sum4')
            ->add('sum5')
            ->add('sum6')
            ->add('sum7')
            ->add('sum8')
            ->add('sum9')
            ->add('sum10')
            ->add('sum11')
            ->add('sum12')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\MainBundle\Entity\Expense'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mainbundle_expense';
    }
}
