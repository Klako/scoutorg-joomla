<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Model\Uid;

require_once 'orgobject.php';

class ScoutOrgModelGrouprole extends OrgObjectModel
{
    protected function getGrouprole()
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

    protected function getType()
    {
        return 'grouprole';
    }

    protected function fetchFormData()
    {
        $grouprole = $this->getGrouprole();
        $data = [];
        if ($grouprole) {
            $data['uid'] = $grouprole->uid->serialize();
            $data['name'] = $grouprole->name;
        }
        return $data;
    }

    public function save(?Uid $uid, $data)
    {
        /** @var ScoutOrgTableGrouprole|CMSObject */
        $grouproleTable = $this->getTable('Grouprole');

        $uid = Uid::deserialize($data['uid']);

        $grouproleData = [
            'name' => $data['name']
        ];

        if ($uid) {
            $grouproleTable->load(['id' => $uid->getId()]);
        }

        // Store the data.
        if (!$grouproleTable->save($grouproleData)) {
            /** @var CMSObject $troopTable */
            /** @var CMSObject $this */
            $this->setError('unable to save grouprole' . $grouproleTable->getError());
            return false;
        }

        $this->setState('grouprole.id', $uid->serialize());

        return true;
    }

    protected function deleteSingle(Uid $uid)
    {
        /** @var ScoutOrgTableGrouprole|CMSObject */
        $grouproleTable = $this->getTable('Grouprole');

        if ($uid->getSource() != 'joomla') {
            return false;
        }

        $grouproleTable->delete($uid->getId());

        return true;
    }
}
