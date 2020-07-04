<?php

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('list');

class JFormFieldTroops extends JFormFieldList
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Troops';

    /**
     * Method to get a list of options for a list input.
     * @return  array  An array of JHtml options.
     */
    protected function getOptions()
    {
        jimport('scoutorg.loader');
        $builder = ScoutOrgLoader::load();
        $troops = $builder->troops;

        $options  = array();

        foreach ($troops as $id => $troop) {
            $options[] = HTMLHelper::_('select.option', $id, $troop->getName());
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
