<?php

use Scouterna\Scoutorg\Model\Branch;

require_once 'orgobjects.php';

class ScoutOrgModelBranchtable extends OrgObjectsModel
{
	protected function getColumns()
	{
		return ['COM_SCOUTORG_BRANCH_NAME'];
	}

	protected function getDataRows()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();
		$rows = [];
		foreach ($scoutgroup->branches as $branch) {
			$rows[$branch->uid->serialize()] = [
				$this->linkEditObject('branch', $branch->uid, $branch->name)
			];
		}
		return $rows;
	}
}
