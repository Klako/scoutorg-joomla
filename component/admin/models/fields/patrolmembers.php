<?php

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die('Restricted access');

require_once 'scoutorgselect.php';

class JFormFieldMembers extends JFormFieldList
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Members';

    /**
     * Method to get a list of options for a list input.
     * @return  array  An array of JHtml options.
     */
    protected function getOptions()
    {
        jimport('scoutorg.loader');
        $scoutgroup = ScoutorgLoader::loadGroup();

        /** @var self|FormField $this */
        $patrolUid = $this->form->getValue('uid');
        if ($patrolUid) {
            $patrolUid = Uid::deserialize($this->form->getValue('uid'));
        }

        $scoutgroup = ScoutorgLoader::loadGroup();

        $options  = array();

        foreach ($scoutgroup->troops as $troop) {
            if ($troop->branch === null || ($patrolUid && $troop->branch->uid == $patrolUid)) {
                $options[] = JHtmlSelect::option($troop->uid->serialize(), $troop->name);
            } else {
                $options[] = JHtmlSelect::option($troop->uid->serialize(), $troop->name, ['disable' => true]);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
