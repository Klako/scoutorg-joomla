<?php

use Scouterna\Scoutorg\Model\Branch;

require_once 'orgobjects.php';

class ScoutOrgModelGroupmembertable extends OrgObjectsModel
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
        /** @var Scouterna\Scoutorg\Model\GroupMember $member */
        foreach ($scoutgroup->members as $member) {
            $personInfo = $member->member->personInfo;
            $name = $personInfo->firstname . ' ' . $personInfo->lastname;
            $rows[$member->uid->serialize()] = [
                $this->linkEditObject('groupmember', $member->uid, $name)
            ];
        }
        return $rows;
    }
}
