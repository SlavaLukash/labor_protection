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

class EquipmentAdmin extends Admin
{
	// Fields to be shown on create/edit forms
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('equipmentsubgroup', 'entity', array('class' => 'Sir\OtBundle\Entity\Equipmentsubgroup'))
			->add('subdivision', 'entity', array('class' => 'Sir\OtBundle\Entity\Subdivision'))
			->add('name', 'text', array('label' => 'Наименование'))
			->add('model', 'text', array('label' => 'Модель'))
			->add('registrationtype', 'entity', array('class' => 'Sir\OtBundle\Entity\Registrationtype'))
			->add('registrationnumber', 'text', array('label' => 'Реистрационный номер'))
			->add('internalnumber', 'text', array('label' => 'Внутренний номер'))
			->add('factorynumber', 'text', array('label' => 'Заводской номер'))
			->add('manufacturer', 'text', array('label' => 'Производитель'))
			->add('productiondate', 'date', array('label' => 'Дата производства', 'years' => range(1900, 2100)))
			->add('startupdate', 'date', array('label' => 'Фактическая дата', 'years' => range(1900, 2100)))
			->add('life', 'integer')
		;
	}

	// Fields to be shown on filter forms
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('equipmentsubgroup')
			->add('subdivision')
			->add('name')
			->add('model')
			->add('registrationtype')
			->add('registrationnumber')
			->add('internalnumber')
			->add('factorynumber')
			->add('manufacturer')
			->add('productiondate')
			->add('startupdate')
			->add('life')
		;
	}

	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('equipmentsubgroup')
			->add('subdivision')
			->addIdentifier('name')
			->add('model')
			->add('registrationtype')
			->add('registrationnumber')
			->add('internalnumber')
			->add('factorynumber')
			->add('manufacturer')
			->add('productiondate')
			->add('startupdate')
			->add('life')
		;
	}
}