<?php

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('subform');

class JFormFieldOrgobjectsubform extends JFormFieldSubform
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Orgobjectsubform';

    protected function getInput()
    {
        /** @var JFormFieldOrgobjectsubform|FormField $this */
        $this->buttons = $this->form->subformbuttons;
        return parent::getInput();
    }
}
