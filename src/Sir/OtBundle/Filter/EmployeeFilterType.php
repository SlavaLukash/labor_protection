<?php
/**
 * Created by PhpStorm.
 * User: ibragimovrt
 * Date: 29.11.13
 * Time: 10:10
 */

namespace Sir\OtBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class EmployeeFilterType extends AbstractType
{
	protected $sdArray;

	public function __construct($sdArray = null, $entArray = null) {
		foreach($sdArray as $subD)
		{
			$this->sdArray[$subD->getEnterprise()->getName()][] = $subD->getName();
		}
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'filter_text', array(
			'label' => 'Ф.И.О',
			'apply_filter' => array($this, 'fioVariantsFieldCallback')
		));
		$builder->add('subdivision', 'filter_choice', array(
			'empty_value' => 'Все',
			'choices' => $this->sdArray,
			'apply_filter' => array($this, 'subdivisionFieldCallback')
		));
	}

	public function getName()
	{
		return 'subdivision_filter';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'csrf_protection'   => false,
			'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
		));
	}

	public function subdivisionFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.subdivision', 'ee');
			$qb->andWhere("LOWER(ee.name) LIKE LOWER('%{$values['value']}%')");
			$qb->orderBy('ee.id', 'ASC');
		}
	}

	public function fioVariantsFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$aValues = explode(' ', $values['value']);
			$query = '';
			foreach($aValues as $key => $val)
			{
				if($key == 0)
				{
					$query .= "LOWER(e.firstname) LIKE LOWER('%{$val}%') OR LOWER(e.lastname) LIKE LOWER('%{$val}%') OR LOWER(e.middlename) LIKE LOWER('%{$val}%')";
				} else {
					$query .= " OR LOWER(e.firstname) LIKE LOWER('%{$val}%') OR LOWER(e.lastname) LIKE LOWER('%{$val}%') OR LOWER(e.middlename) LIKE LOWER('%{$val}%')";
				}
			}
			$qb = $filterQuery->getQueryBuilder();
			$qb->andWhere($query);
		}
	}

} 