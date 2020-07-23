<?php

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

require_once 'orgobjects.php';

class ScoutOrgModelGrouproletable extends OrgObjectsModel
{

    protected function getColumns()
    {
        return ['Name'];
    }

    protected function getDataRows()
    {
        jimport('scoutorg.loader');
        $scoutgroup = ScoutorgLoader::loadGroup();
        $rows = [];
        foreach ($scoutgroup->groupRoles as $grouprole){
            $rows[$grouprole->uid->serialize()] = [
                $this->linkEditObject('grouprole', $grouprole->uid, $grouprole->name)
            ];
        }
        return $rows;
    }
}
