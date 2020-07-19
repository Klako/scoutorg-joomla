<?php

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class ScoutOrgModelTroops extends BaseDatabaseModel
{
	public function getTroops()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();
		return $scoutgroup->troops;
	}
}
