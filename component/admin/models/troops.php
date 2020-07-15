<?php

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Builder\Uid;

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
		return null;
	}

	
}
