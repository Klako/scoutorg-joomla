<?php

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('list');

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

        $options = [];

        if ($this->required) {
            $options[] = JHtmlSelect::option('', Text::_('JGLOBAL_SELECT_AN_OPTION'));
        } else {
            $options[] = JHtmlSelect::option('', Text::_('JNONE'));
        }

        foreach ($scoutgroup->members as $member) {
            $name = "{$member->personInfo->firstname} {$member->personInfo->lastname}";
            $options[] = JHtmlSelect::option("{$member->source}:{$member->id}", $name);
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
