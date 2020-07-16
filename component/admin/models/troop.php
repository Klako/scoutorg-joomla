<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Model\Uid;

class ScoutOrgModelTroop extends FormModel
{
    public function getTable($type = 'Troop', $prefix = 'ScoutOrgTable', $config = array())
    {
        return Joomla\CMS\Table\Table::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm(
            'com_scoutorg.troop',
            'troop',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = Joomla\CMS\Factory::getApplication()->getUserState(
            'com_scoutorg.edit.troop.data',
            array()
        );

        if (empty($data)) {
            $troop = $this->getTroop();
            if ($troop) {
                $data['id'] = $troop->uid->serialize();
                $data['name'] = $troop->name;
                $branch = $troop->branch;
                if ($branch) {
                    $data['branch'] = $branch->uid->serialize();
                }
            }
        }

        return $data;
    }

    public function getTroop()
    {
        jimport('scoutorg.loader');
        $uid = Factory::getApplication()->input->getString('id');
        if (!$uid) {
            return null;
        }
        $uid = Uid::deserialize($uid);
        $scoutgroup = ScoutorgLoader::loadGroup();
        $troop = $scoutgroup->troops->get($uid);
        return $troop;
    }

    public function save($data)
    {
        jimport('scoutorg.loader');

        /** @var ScoutOrgTableBranchtroop */
        $branchTroopTable = $this->getTable('Branchtroop');
        /** @var ScoutOrgTableTroop */
        $troopTable = $this->getTable();

        $uid = Uid::deserialize($data['id']);

        $troopTableData = [
            'name' => $data['name']
        ];

        if ($uid) {
            $troopTableData['id'] = $uid->getId();
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

        if (!$branchTroopTable->save($branchTroopData)) {
            /** @var CMSObject $branchTroopTable */
            /** @var CMSObject $this */
            $this->setError('unable to save branchtroop' . $branchTroopTable->getError());

            $troopTable->delete();

            return false;
        }

        return true;
    }
}
