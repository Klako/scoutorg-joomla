<?php

use Joomla\CMS\MVC\Model\AdminModel;

class ScoutOrgModelTroops extends AdminModel
{
	public function getTroops()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();
		return $scoutgroup->troops;
	}

	public function getTable($name = 'Troop', $prefix = 'ScoutOrgTable', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_scoutorg.troop',
			'troop',
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
