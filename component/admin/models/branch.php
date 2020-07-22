<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Model\Uid;

require_once 'orgobject.php';

class ScoutorgModelBranch extends OrgObjectModel
{
    public function getBranch()
    {
        jimport('scoutorg.loader');
        $uid = Factory::getApplication()->input->getString('uid');
        if (!$uid) {
            return null;
        }
        $uid = Uid::deserialize($uid);
        $scoutorg = ScoutorgLoader::load();
        $branch = $scoutorg->branches->get($uid);
        return $branch;
    }

    protected function fetchFormData()
    {
        $data = [];
        $branch = $this->getBranch();
        if ($branch) {
            $data['uid'] = $branch->uid->serialize();
            $data['name'] = $branch->name;
            $data['troops'] = [];
            foreach ($branch->troops as $troop) {
                $data['troops'][] = $troop->uid->serialize();
            }
        }
        return $data;
    }

    public function save(?Uid &$uid, $data)
    {
        jimport('scoutorg.loader');

        if (!$this->startTransaction()) {
            return false;
        }

        if (!$this->syncObjectBase('#__scoutorg_branches', $uid, ['name' => $data['name']])) {
            return false;
        }

        if (!$this->syncObjectLinks('#__scoutorg_branchtroops', $uid, 'branch', 'troop', $data['troops'] ?? [])) {
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
            if (!$this->easyDelete('#__scoutorg_branches', 'id', $uid->getId())) {
                return false;
            }
            if (!$this->easyDelete('#__scoutorg_branchtroops', 'branch', $uid->serialize())) {
                return false;
            }
        }
        return true;
    }
}
