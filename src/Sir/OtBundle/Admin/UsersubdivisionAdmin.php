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
use Symfony\Component\Security\Core\SecurityContextInterface;

class UsersubdivisionAdmin extends Admin
{

	// Fields to be shown on create/edit forms
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('usersubdivisions', 'entity', array('label' => 'Пользователь', 'class' => 'Sir\OtBundle\Entity\User'))
			->add('usersubdivisions', 'sonata_type_model', array('label' => 'Подразделение', 'class' => 'Sir\OtBundle\Entity\Subdivision',
				'required' => true,
				'multiple' => true,
				'expanded' => true));
	}

	// Fields to be shown on filter forms
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('username')
			->add('usersubdivisions')
		;
	}

	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('username')
			->add('usersubdivisions')
		;
	}
}