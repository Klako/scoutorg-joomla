<?php

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class ScoutOrgModelBranches extends BaseDatabaseModel
{
	public function getBranches()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();

		return $scoutgroup->branches;
	}
}
