<?php

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;
use Scouterna\Scoutorg\Model\Uid;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('text');

class JFormFieldScoutorgtext extends JFormFieldText
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Scoutorgtext';

    protected function getInput()
    {
        /** @var JFormFieldScoutorgtext|FormField $this */
        jimport('scoutorg.loader');
        $uid = Uid::deserialize($this->form->getValue('uid') ?? '');
        if ($uid) {
            $this->readonly = $uid->getSource() != 'joomla';
        }
        return parent::getInput();
    }
}
