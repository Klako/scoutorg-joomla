<?php

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;

class ScoutOrgModelBranches extends AdminModel
{
	public function getBranches()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();

		return $scoutgroup->branches;
	}

	/**
	 * @inheritdoc
	 * @return Table
	 */
	public function getTable($name = 'Branch', $prefix = 'ScoutOrgTable', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_scoutorg.branch',
			'branch',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);

		if (empty($form)) {
			return false;
		}

		return $form;
	}
}
