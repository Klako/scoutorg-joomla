<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Model\Uid;

require_once 'orgobject.php';

class ScoutOrgModelGrouprole extends OrgObjectModel
{
    public function getGrouprole()
    {
        jimport('scoutorg.loader');
        $uid = Factory::getApplication()->input->getString('uid');
        if (!$uid) {
            return null;
        }
        $uid = Uid::deserialize($uid);
        $scoutorg = ScoutorgLoader::load();
        $grouprole = $scoutorg->groupRoles->get($uid);
        return $grouprole;
    }

    protected function fetchFormData()
    {
        $grouprole = $this->getGrouprole();
        $data = [];
        if ($grouprole) {
            $data['uid'] = $grouprole->uid->serialize();
            $data['name'] = $grouprole->name;
            $scoutgroup = ScoutorgLoader::loadGroup();
            foreach ($scoutgroup->members as $groupmember) {
                if ($groupmember->roles->exists($grouprole->uid)) {
                    $data['members'][] = $groupmember->uid->serialize();
                }
            }
        }
        return $data;
    }

    public function save(?Uid &$uid, $data)
    {
        if (!$this->startTransaction()) {
            return false;
        }

        if (!$this->syncObjectBase('#__scoutorg_grouproles', $uid, ['name' => $data['name']])) {
            return false;
        }

        $members = $data['members'] ?? [];

        if (!$this->syncObjectLinks('#__scoutorg_groupmemberroles', $uid, 'role', 'groupmember', $members)) {
            return false;
        }

        if (!$this->endTransaction()) {
            return false;
        }

        return true;
    }

    public function delete($uids)
    {
        foreach ($uids as $uid) {
            if ($uid->getSource() != 'joomla') {
                continue;
            }
            if (!$this->easyDelete('#__scoutorg_grouproles', 'id', $uid->getId())) {
                return false;
            }
        }
        return true;
    }
}
