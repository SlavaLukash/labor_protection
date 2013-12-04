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
	protected $req;

	public function __construct() {
		$this->req = 0;
		if(isset($_REQUEST['subdivision_filter']['enterprise']))$this->req =$_REQUEST['subdivision_filter']['enterprise'];
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('enterprise', 'filter_entity', array(
			'class' => 'SirOtBundle:Enterprise',
			'empty_value' => false,
			'apply_filter' => array($this, 'enterpriseFieldCallback')
		));
		$builder->add('subdivision', 'filter_entity', array(
			'empty_value' => 'Все',
			'class' => 'SirOtBundle:Subdivision',
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

	public function enterpriseFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->select('e')
				->leftJoin('e.subdivision', 'ee')
				->where('ee.enterprise = ' . $this->req)
				->orderBy('e.id', 'DESC');
		}
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

} 