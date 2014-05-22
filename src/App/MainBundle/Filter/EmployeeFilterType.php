<?php
/**
 * Created by PhpStorm.
 * User: ibragimovrt
 * Date: 29.11.13
 * Time: 10:10
 */

namespace App\MainBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class EmployeeFilterType extends AbstractType
{
	protected $aSubdivisions;
	protected $aUserSubdivisions;

	public function __construct($aSubdivisions = null, $entArray = null) {
		foreach($aSubdivisions as $subD)
		{
			$this->aSubdivisions[$subD->getEnterprise()->getName()][$subD->getId()] = $subD->getName();
			$this->aUserSubdivisions[] = $subD->getId();
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
			'choices' => $this->aSubdivisions,
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
			$qb->andWhere("ee.id = {$values['value']}");
			$qb->orderBy('ee.id', 'ASC');
		} else {
			$qb = $filterQuery->getQueryBuilder();
			$qb->innerJoin('e.subdivision', 'ee');
            if($this->aUserSubdivisions) {
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