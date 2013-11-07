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

class TechnicalexaminationAdmin extends Admin
{
	// Fields to be shown on create/edit forms
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('equipment', 'entity', array('class' => 'Sir\OtBundle\Entity\Equipment'))
			->add('technicalexaminationkind', 'entity', array('class' => 'Sir\OtBundle\Entity\Technicalexaminationkind'))
			->add('technicalexaminationcause', 'entity', array('class' => 'Sir\OtBundle\Entity\Technicalexaminationcause'))
			->add('technicalexaminationtype', 'entity', array('class' => 'Sir\OtBundle\Entity\Technicalexaminationtype'))
			->add('plandate', 'date', array('label' => 'Планируемая дата', 'years' => range(1900, 2100)))
			->add('factdate', 'date', array('label' => 'Фактическая дата', 'years' => range(1900, 2100)))
			->add('resulttext', 'text', array('label' => 'Результаты'))
		;
	}

	// Fields to be shown on filter forms
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('equipment')
			->add('technicalexaminationkind')
			->add('technicalexaminationcause')
			->add('technicalexaminationtype')
			->add('plandate')
			->add('factdate')
			->add('resulttext')
		;
	}

	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->addIdentifier('equipment')
			->add('technicalexaminationkind')
			->add('technicalexaminationcause')
			->add('technicalexaminationtype')
			->add('plandate')
			->add('factdate')
			->add('resulttext')
		;
	}
}