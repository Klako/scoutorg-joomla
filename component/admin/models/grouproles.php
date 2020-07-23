<?php

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class ScoutOrgModelGrouproles extends BaseDatabaseModel
{
    public function getGrouproles()
    {
        jimport('scoutorg.loader');
        $scoutgroup = ScoutorgLoader::loadGroup();

        return $scoutgroup->groupRoles;
    }
}
