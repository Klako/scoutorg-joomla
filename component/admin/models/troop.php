<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\AdminModel;

class ScoutOrgModelTroop extends AdminModel
{
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
            $data = $this->getItem();
        }

        return $data;
    }
}
