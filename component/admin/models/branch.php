<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
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

    protected function getType()
    {
        return 'Branch';
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

    public function save(?Uid $uid, $data)
    {
        jimport('scoutorg.loader');

        if (!$this->startTransaction()) {
            return false;
        }

        $q = $this->newQuery();
        if ($uid && $uid->getSource() == 'joomla') {
            $q->update('#__scoutorg_branches')
                ->set("{$q->qn('name')} = {$q->q($data['name'])}")
                ->where("{$q->qn('id')} = {$q->q($uid->getId())}");
        } elseif (!$uid) {
            $q->insert('#__scoutorg_branches')
                ->columns($q->qn('name'))
                ->values($q->q($data['name']));
        }
        if (!$this->executeQuery($q)) {
            return false;
        }

        $inserts = [];
        foreach ($data['troops'] ?? [] as $troop) {
            $inserts[$troop] = $troop;
        }
        $removes = [];

        if (!$uid) {
            $uid = new Uid('joomla', Factory::getDbo()->insertid());
        } else {
            $scoutorg = ScoutorgLoader::load();
            $branch = $scoutorg->branches->get($uid);
            foreach ($branch->troops as $troop) {
                $insert = $troop->uid->serialize();
                if (!$inserts[$insert]) {
                    $removes[] = $insert;
                } else {
                    unset($inserts[$insert]);
                }
            }
        }

        if (!empty($inserts)) {
            $q = $this->newQuery();
            $inserts = array_map(function ($troop) use ($uid, $q) {
                return "{$q->q($uid->serialize())},{$q->q($troop)}";
            }, $inserts);
            $q->insert('#__scoutorg_branchtroops')
                ->columns(['branch', 'troop'])
                ->values($inserts);
            if (!$this->executeQuery($q)) {
                return false;
            }
        }

        if (!empty($removes)) {
            $q = $this->newQuery();
            $removes = implode(',', array_map(function ($troop) use ($q) {
                return $q->q($troop);
            }, $removes));
            $q->delete('#__scoutorg_branchtroops')
                ->where("{$q->qn('troop')} IN ($removes)");
            if (!$this->executeQuery($q)) {
                return false;
            }
        }

        if (!$this->endTransaction()) {
            return false;
        }

        $this->setState('branch.id', $uid->serialize());

        return true;
    }

    protected function deleteSingle(Uid $uid)
    {
        /** @var ScoutOrgTableBranch|CMSObject */
        $branchTable = $this->getTable('Branch');

        if ($uid->getSource() != 'joomla') {
            return false;
        }

        $branchTable->delete($uid->getId());

        /** @var ScoutOrgTableBranchtroop|CMSObject */
        $branchtroopTable = $this->getTable('Branchtroop');

        while ($branchtroopTable->load(['branch' => $uid->serialize()])) {
            $branchtroopTable->delete();
        }

        return true;
    }
}
