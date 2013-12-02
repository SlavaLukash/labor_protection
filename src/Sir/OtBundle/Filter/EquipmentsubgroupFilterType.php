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

class EquipmentsubgroupFilterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'filter_text', array(
			'apply_filter' => array($this, 'textFieldCallback')
		));
		$builder->add('equipmentgroup', 'filter_text', array(
			'apply_filter' => array($this, 'equipmentgroupFieldCallback')
		));
	}

	public function getName()
	{
		return 'equipmentsubgroup_filter';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'csrf_protection'   => false,
			'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
		));
	}


	public function equipmentgroupFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.equipmentgroup', 'ee');
			$qb->andWhere("LOWER(ee.name) LIKE LOWER('%{$values['value']}%')");
			$qb->orderBy('ee.id', 'ASC');
		}
	}

	public function textFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->andWhere("LOWER({$field}) LIKE LOWER('%{$values['value']}%')");
		}
	}

} 