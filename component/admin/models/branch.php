<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\AdminModel;

class ScoutorgModelBranch extends AdminModel
{
    public function getTable($type = 'Branch', $prefix = 'ScoutOrgTable', $config = array())
    {
        return Joomla\CMS\Table\Table::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm(
            'com_scoutorg.branch',
            'branch',
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
        $data = \Joomla\CMS\Factory::getApplication()->getUserState(
            'com_scoutorg.edit.branch.data',
            array()
        );

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }
}
