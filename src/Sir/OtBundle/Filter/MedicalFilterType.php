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

class MedicalFilterType extends AbstractType
{
	protected $aSubdivisions;
	protected $aUserSubdivisions;

	public function __construct($aSubdivisions = null, $entArray = null) {
		foreach($aSubdivisions as $subD)
		{
			$this->aSubdivisions[$subD->getEnterprise()->getName()][$subD->getId()] = $subD;
			$this->aUserSubdivisions[] = $subD->getId();
		}
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('employee', 'filter_text', array(
			'label' => 'Ф.И.О',
			'apply_filter' => array($this, 'fioVariantsFieldCallback')
		));
		$builder->add('subdivision', 'filter_choice', array(
			'empty_value' => 'Все',
			'choices' => $this->aSubdivisions,
			'apply_filter' => array($this, 'subdivisionFieldCallback')
		));
		$builder->add('dateplan', 'filter_date_range', array(
			'left_date_options' => array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			),
			'right_date_options' => array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			),
		));
		$builder->add('datefact', 'filter_date_range', array(
			'left_date_options' => array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			),
			'right_date_options' => array(
				'widget' => 'single_text',
				'format' => 'dd.MM.yyyy',
				'attr' => array('class' => 'date-input')
			),
		));
	}

	public function getName()
	{
		return 'medicalkind_filter';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'csrf_protection'   => false,
			'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
		));
	}

	public function textFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->andWhere("LOWER({$field}) LIKE LOWER('%{$values['value']}%')");
		}
	}

	public function subdivisionFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.employee', 'es');
			$qb->andWhere("es.subdivision = {$values['value']}");
			$qb->orderBy('es.id', 'ASC');
		} else {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.employee', 'es');
			$query = '';
			foreach($this->aUserSubdivisions as $key => $val)
			{
				if($key == 0)
				{
					$query .= "es.subdivision = {$val}";
				} else {
					$query .= " OR es.subdivision = {$val}";
				}
			}
			$qb->andWhere($query);
			$qb->orderBy('es.id', 'ASC');
		}
	}

	public function fioVariantsFieldCallback(QueryInterface $filterQuery, $field, $values)
	{
		if (!empty($values['value'])) {
			$aValues = explode(' ', $values['value']);
			$query = '';
			foreach($aValues as $key => $val)
			{
				$val = str_replace("'",'',$val);
				if($key == 0)
				{
					$query .= "LOWER(ee.firstname) LIKE LOWER('%{$val}%') OR LOWER(ee.lastname) LIKE LOWER('%{$val}%') OR LOWER(ee.middlename) LIKE LOWER('%{$val}%')";
				} else {
					$query .= " OR LOWER(ee.firstname) LIKE LOWER('%{$val}%') OR LOWER(ee.lastname) LIKE LOWER('%{$val}%') OR LOWER(ee.middlename) LIKE LOWER('%{$val}%')";
				}
			}
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.employee', 'ee');
			$qb->andWhere($query);
		}
	}

} 