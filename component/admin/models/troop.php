<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Builder\Uid;

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
            jimport('scoutorg.loader');
            $uid = Factory::getApplication()->input->getInt('id');
            $uid = Uid::deserialize($uid);
            $scoutgroup = ScoutorgLoader::loadGroup();
            $troop = $scoutgroup->troops->get('joomla', $data->id);
            $branch = $troop->branch;
            if ($branch){
                $data['branch'] = (new Uid($branch->source, $branch->id))->serialize();
            }
        } else {

        }

        return $data;
    }

    public function save($data)
    {
        /** @var ScoutOrgTableBranchtroop */
        $branchTroopTable = $this->getTable('Branchtroop');
        /** @var ScoutOrgTableTroop */
        $troopTable = $this->getTable();

        $troopTableData = [
            'id' => $data['id'],
            'name' => $data['name']
        ];

        // Store the data.
        if (!$troopTable->save($troopTableData)) {
            /** @var CMSObject $troopTable */
            /** @var CMSObject $this */
            $this->setError('unable to save troop' . $troopTable->getError());
            return false;
        }

        jimport('scoutorg.loader');
        $branchTroopData = [
            'branch' => $data['branch'],
            'troop' => (new Uid('joomla', $troopTable->id))->serialize()
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
