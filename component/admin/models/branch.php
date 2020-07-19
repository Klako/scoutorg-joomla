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
        }
        return $data;
    }

    public function save($data)
    {
        jimport('scoutorg.loader');
        /** @var ScoutOrgTableBranch|CMSObject */
        $branchTable = $this->getTable('Branch');

        $uid = Uid::deserialize($data['uid']);

        $branchTableData = [
            'name' => $data['name']
        ];

        if ($uid) {
            $branchTable->load(['id' => $uid->getId()]);
        }

        // Store the data.
        if (!$branchTable->save($branchTableData)) {
            /** @var CMSObject $troopTable */
            /** @var CMSObject $this */
            $this->setError('unable to save branch' . $branchTable->getError());
            return false;
        }

        $uid = new Uid('joomla', $branchTable->id);

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

        return true;
    }
}
