<?php

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

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
        $scoutgroup = ScoutorgLoader::loadGroup();
        $troops = $scoutgroup->troops;

        $options  = array();

        if ($this->required) {
            $options[] = JHtmlSelect::option('', Text::_('JGLOBAL_SELECT_AN_OPTION'));
        } else {
            $options[] = JHtmlSelect::option('', Text::_('JNONE'));
        }

        foreach ($scoutgroup->troops as $troop) {
            $options[] = HTMLHelper::_('select.option', "{$troop->source}:{$troop->id}", $troop->name);
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
