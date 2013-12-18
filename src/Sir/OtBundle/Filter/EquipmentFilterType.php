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

class EquipmentFilterType extends AbstractType
{
	protected $aSubdivisions;
	protected $aUserSubdivisions;
	protected $aESubGroup;
	protected $aESubGroupIds;

	public function __construct($aSubdivisions = null, $entArray = null, $aESubGroup = null) {
		foreach($aSubdivisions as $subD)
		{
			$this->aSubdivisions[$subD->getEnterprise()->getName()][$subD->getId()] = $subD->getName();
			$this->aUserSubdivisions[] = $subD->getId();
		}
		foreach($aESubGroup as $subGroup)
		{
			$this->aESubGroup[$subGroup->getEquipmentgroup()->getName()][$subGroup->getId()] = $subGroup->getName();
			$this->aESubGroupIds[] = $subGroup->getId();
		}
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'filter_text', array(
			'apply_filter' => array($this, 'textFieldCallback')
		));
		$builder->add('subdivision', 'filter_choice', array(
			'empty_value' => 'Все',
			'choices' => $this->aSubdivisions,
			'apply_filter' => array($this, 'subdivisionFieldCallback')
		));
		$builder->add('equipmentsubgroup', 'filter_choice', array(
			'empty_value' => 'Все',
			'choices' => $this->aESubGroup,
			'apply_filter' => array($this, 'equipmentsubgroupFieldCallback')
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
			$qb->andWhere("ee.id = {$values['value']}");
			$qb->orderBy('ee.id', 'ASC');
		} else {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.subdivision', 'ee');
			$query = '';
			foreach($this->aUserSubdivisions as $key => $val)
			{
				if($key == 0)
				{
					$query .= "ee.id = {$val}";
				} else {
					$query .= " OR ee.id = {$val}";
				}
			}
			$qb->andWhere($query);
			$qb->orderBy('ee.id', 'ASC');
		}
	}

	public function equipmentsubgroupFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.equipmentsubgroup', 'es');
			$qb->andWhere("es.id = {$values['value']}");
			$qb->orderBy('es.id', 'ASC');
		} else {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.equipmentsubgroup', 'es');
			$query = '';
			foreach($this->aESubGroupIds as $key => $val)
			{
				if($key == 0)
				{
					$query .= "es.id = {$val}";
				} else {
					$query .= " OR es.id = {$val}";
				}
			}
			$qb->andWhere($query);
			$qb->orderBy('es.id', 'ASC');
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