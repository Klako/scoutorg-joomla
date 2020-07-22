<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Scouterna\Scoutorg\Model\Uid;

FormHelper::loadFieldClass('list');

class JFormFieldBranchtroops extends JFormFieldList
{
    protected function getOptions()
    {
        jimport('scoutorg.loader');

        /** @var self|FormField $this */
        $branchUid = $this->form->getValue('uid');
        if ($branchUid) {
            $branchUid = Uid::deserialize($this->form->getValue('uid'));
        }

        $scoutgroup = ScoutorgLoader::loadGroup();

        $options  = array();

        foreach ($scoutgroup->troops as $troop) {
            if ($troop->branch === null || ($branchUid && $troop->branch->uid == $branchUid)) {
                $options[] = JHtmlSelect::option($troop->uid->serialize(), $troop->name);
            } else {
                $options[] = JHtmlSelect::option($troop->uid->serialize(), $troop->name, ['disable' => true]);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
