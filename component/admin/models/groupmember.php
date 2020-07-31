<?php

use Joomla\CMS\Factory;
use Scouterna\Scoutorg\Model\Uid;

require_once 'orgobject.php';

class ScoutOrgModelGroupmember extends OrgObjectModel
{
    public function getGroupMember()
    {
        jimport('scoutorg.loader');
        $uid = Factory::getApplication()->input->getString('uid');
        if (!$uid) {
            return null;
        }
        $uid = Uid::deserialize($uid);
        $scoutorg = ScoutorgLoader::load();
        $groupmember = $scoutorg->groupMembers->get($uid);
        return $groupmember;
    }

    protected function fetchFormData()
    {
        $groupmember = $this->getGroupMember();
        $data = [];
        if ($groupmember) {
            $data['uid'] = $groupmember->uid->serialize();
            $personInfo = $groupmember->member->personInfo;
            $data['name'] = $personInfo->firstname . ' ' . $personInfo->lastname;
            $scoutgroup = ScoutorgLoader::loadGroup();
            $data['grouproles'] = [
                $scoutgroup->groupRoles,
                $groupmember->roles,
                function ($grouprole){
                    return $grouprole->name;
                }
            ];
        }
        return $data;
    }

    public function save(?Uid &$uid, $data)
    {
        if (!$this->startTransaction()) {
            return false;
        }

        $grouproles = $data['grouproles'] ?? [];

        if (!$this->syncObjectLinks('#__scoutorg_groupmemberroles', $uid, 'groupmember', 'role', $grouproles)) {
            return false;
        }

        if (!$this->endTransaction()) {
            return false;
        }

        return true;
    }

    public function delete($uids)
    {
    }
}
