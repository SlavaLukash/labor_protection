<?php
/**
 * @author Rustam Ibragimov
 * @mail Rustam.Ibragimov@softline.ru
 * @date 06.11.13
 */

namespace Sir\OtBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EmployeeAdmin extends Admin
{
	// Fields to be shown on create/edit forms
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('subdivision', 'entity', array('label' => 'Подразделение', 'class' => 'Sir\OtBundle\Entity\Subdivision'))
			->add('profession', 'entity', array('label' => 'Профессия', 'class' => 'Sir\OtBundle\Entity\Profession'))
			->add('lastname', 'text', array('label' => 'Фамилия'))
			->add('firstname', 'text', array('label' => 'Имя'))
			->add('middlename', 'text', array('label' => 'Отчество'))
			->add('sex', 'choice', array('label' => 'Пол', 'choices' => array(1 => 'М', 0 => 'Ж')))
			->add('marriagekind', 'entity', array('label' => 'Семейное положение', 'class' => 'Sir\OtBundle\Entity\Marriagekind'))
			->add('bithday', 'date', array('label' => 'Дата рождения', 'years' => range(1900, 2100)))
			->add('date_first_medical', 'date', array('label' => 'Дата первого мед.осмотра', 'years' => range(1900, 2100)))
			->add('date_instruction', 'date', array('label' => 'Дата инструктажа', 'years' => range(1900, 2100)))
		;
	}

	// Fields to be shown on filter forms
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('subdivision')
			->add('profession')
			->add('lastname')
			->add('firstname')
			->add('middlename')
			->add('sex')
			->add('marriagekind')
			->add('bithday')
			->add('date_first_medical')
			->add('date_instruction')
		;
	}

	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('subdivision')
			->add('profession')
			->add('lastname')
			->add('firstname')
			->add('middlename')
			->add('sex')
			->add('marriagekind')
			->add('bithday')
			->add('date_first_medical')
			->add('date_instruction')
		;
	}
}