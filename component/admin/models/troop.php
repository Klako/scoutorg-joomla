<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Scouterna\Scoutorg\Model\Uid;

require_once 'orgobject.php';
require_once 'subformbuttons.php';

class ScoutOrgModelTroop extends OrgObjectModel
{
    private $removePattern = [];

    protected function getType()
    {
        return 'Troop';
    }

    /**
     * 
     * @param Form $form 
     * @param mixed $data 
     * @param string $group 
     * @return void 
     */
    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);
        $buttons = new SubformButtons([true], $this->removePattern, [true]);
        $form->subformbuttons = $buttons;
        jimport('scoutorg.loader');
        if (($uid = Uid::deserialize($data['uid'] ?? '')) && $uid->getSource() != 'joomla') {
            $form->setFieldAttribute('name', 'readonly', 'true');
        }
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
            $this->removePattern = [];
            foreach ($troop->patrols as $patrol) {
                if ($patrol->uid->getSource() == 'joomla') {
                    $this->removePattern[] = true;
                } else {
                    $this->removePattern[] = false;
                }
                $data['patrols'][] = [
                    'uid' => $patrol->uid->serialize(),
                    'name' => $patrol->name,
                    'source' => $patrol->uid->getSource()
                ];
            }
        }
        return $data;
    }

    protected function getTroop()
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

    public function save(?Uid &$uid, $data)
    {
        jimport('scoutorg.loader');

        if (!$this->startTransaction()) {
            return false;
        }

        if (!$this->syncObjectBase('#__scoutorg_troops', $uid, ['name' => $data['name']])) {
            return false;
        }

        $branches = $data['branch'] ? [$data['branch']] : [];

        if (!$this->syncObjectLinks('#__scoutorg_branchtroops', $uid, 'troop', 'branch', $branches)) {
            return false;
        }

        $patrols = $data['patrols'] ?: [];

        if (!$this->syncSubObjects('#__scoutorg_patrols', 'troop', $uid->serialize(), $patrols, ['name'])) {
            return false;
        }

        if (!$this->endTransaction()) {
            return false;
        }

        return true;
    }

    public function delete($uids)
    {
        if (!$this->startTransaction()) {
            return false;
        }

        foreach ($uids as $uid) {
            if ($uid->getSource() != 'joomla') {
                continue;
            }
            if (!$this->easyDelete('#__scoutorg_troops', 'id', $uid->getId())) {
                return false;
            }
            if (!$this->easyDelete('#__scoutorg_branchtroops', 'troop', $uid->serialize())) {
                return false;
            }
            if (!$this->easyDelete('#__scoutorg_patrols', 'troop', $uid->serialize())) {
                return false;
            }
        }

        if (!$this->endTransaction()) {
            return false;
        }

        return true;
    }
}
