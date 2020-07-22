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

    public function getTroop()
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

    public function save(?Uid $uid, $data)
    {
        jimport('scoutorg.loader');

        /** @var ScoutOrgTableBranchtroop */
        $branchTroopTable = $this->getTable('Branchtroop');
        /** @var ScoutOrgTableTroop */
        $troopTable = $this->getTable('Troop');

        $uid = Uid::deserialize($data['uid']);

        $troopTableData = [
            'name' => $data['name']
        ];

        if ($uid) {
            $troopTable->load(['id' => $uid->getId()]);
        }

        // Store the data.
        if (!$troopTable->save($troopTableData)) {
            /** @var CMSObject $troopTable */
            /** @var CMSObject $this */
            $this->setError('unable to save troop' . $troopTable->getError());
            return false;
        }

        $uid = new Uid('joomla', $troopTable->id);

        $branchTroopData = [
            'branch' => $data['branch'],
            'troop' => $uid->serialize()
        ];

        $branchTroopTable->load(['troop' => $uid->serialize()]);

        if (!$branchTroopTable->save($branchTroopData)) {
            /** @var CMSObject $branchTroopTable */
            /** @var CMSObject $this */
            $this->setError('unable to save branchtroop' . $branchTroopTable->getError());

            $troopTable->delete();

            return false;
        }

        $this->setState('troop.id', $uid->serialize());

        return true;
    }

    protected function deleteSingle(Uid $uid)
    {
        /** @var ScoutOrgTableTroop|CMSObject */
        $troopTable = $this->getTable('Troop');
        /** @var ScoutOrgTableBranchtroop|CMSObject */
        $branchtroopTable = $this->getTable('Branchtroop');

        if ($uid->getSource() != 'joomla') {
            return false;
        }

        $troopTable->delete($uid->getId());

        if ($branchtroopTable->load(['troop' => $uid->serialize()])) {
            $branchtroopTable->delete();
        }

        return true;
    }
}
