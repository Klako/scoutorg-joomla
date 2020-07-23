<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Model\Uid;

include_once 'orgobject.php';

class ScoutOrgModelTroop extends OrgObjectModel
{
    protected function getType()
    {
        return 'Troop';
    }

    protected function fetchFormData()
    {
        $data = [];
        $troop = $this->getTroop();
        if ($troop) {
            $data['uid'] = $troop->uid->serialize();
            $data['name'] = $troop->name;
            $branch = $troop->branch;
            if ($branch) {
                $data['branch'] = $branch->uid->serialize();
            }
        }
        return $data;
    }

    protected function getTroop()
    {
        jimport('scoutorg.loader');
        $uid = Factory::getApplication()->input->getString('uid');
        if (!$uid) {
            return null;
        }
        $uid = Uid::deserialize($uid);
        $scoutgroup = ScoutorgLoader::loadGroup();
        $troop = $scoutgroup->troops->get($uid);
        return $troop;
    }

    public function save(?Uid &$uid, $data)
    {
        jimport('scoutorg.loader');

        if (!$this->startTransaction()) {
            return false;
        }

        if (!$this->syncObjectBase('#__scoutorg_troops', $uid, ['name' => $data['name']])) {
            return false;
        }

        $branches = $data['branch'] ? [$data['branch']] : [];

        if (!$this->syncObjectLinks('#__scoutorg_branchtroops', $uid, 'troop', 'branch', $branches)) {
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
            if (!$this->easyDelete('#__scoutorg_troops', 'id', $uid->getId())) {
                return false;
            }
            if (!$this->easyDelete('#__scoutorg_branchtroops', 'troop', $uid->serialize())) {
                return false;
            }
        }
        return true;
    }
}
