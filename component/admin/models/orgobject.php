<?php

use Joomla\CMS\MVC\Model\FormModel;
use Scouterna\Scoutorg\Model\Uid;

abstract class OrgObjectModel extends FormModel
{
    public function getTable($type = '', $prefix = 'ScoutOrgTable', $config = array())
    {
        return Joomla\CMS\Table\Table::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $formName = strtolower($this->getType());

        $form = $this->loadForm(
            "com_scoutorg.$formName",
            $formName,
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

    protected abstract function getType();

    protected function loadFormData()
    {
        $type = $this->getType();

        // Check the session for previously entered form data.
        $data = Joomla\CMS\Factory::getApplication()->getUserState(
            "com_scoutorg.edit.$type.data",
            array()
        );

        if (empty($data)) {
            $data = $this->fetchFormData();
        }

        return $data;
    }

    protected abstract function fetchFormData();

    public abstract function save($data);

    public function delete($uids)
    {
        jimport('scoutorg.loader');
        foreach ($uids as $uid) {
            $uid = Uid::deserialize($uid);
            if (!$this->deleteSingle($uid)) {
                return false;
            }
        }
    }

    protected abstract function deleteSingle(Uid $uid);
}
