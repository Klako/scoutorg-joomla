<?php

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

require_once 'orgobjects.php';

class ScoutOrgModelTrooptable extends OrgObjectsModel
{

	protected function getColumns()
	{
		return ['Name', 'Branch'];
	}

	protected function getDataRows()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();
		$rows = [];
		foreach ($scoutgroup->troops as $troop) {
			$row = [];
			$row[] = $this->linkEditObject('troop', $troop->uid, $troop->name);
			if ($troop->branch) {
				$row[] = $this->linkEditObject('branch', $troop->branch->uid, $troop->branch->name);
			} else {
				$row[] = 'None';
			}
			$rows[$troop->uid->serialize()] = $row;
		}
		return $rows;
	}
}
