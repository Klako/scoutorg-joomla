<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Object\CMSObject;
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

    public abstract function save(?Uid $uid, $data);

    protected function startTransaction()
    {
        $db = Factory::getDbo();
        try {
            $db->transactionStart(true);
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            return false;
        }
        return true;
    }

    protected function newQuery()
    {
        $db = Factory::getDbo();
        return $db->getQuery(true);
    }

    protected function executeQuery($query)
    {
        $db = Factory::getDbo();
        $db->setQuery($query);
        try {
            if (!$db->execute($query)) {
                /** @var CMSObject $this */
                $this->setError($db->getErrorMsg());
                return false;
            }
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            return false;
        }
        return true;
    }

    protected function endTransaction()
    {
        $db = Factory::getDbo();
        try {
            $db->transactionCommit();
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            $db->transactionRollback(true);
            return false;
        }
        return true;
    }

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
