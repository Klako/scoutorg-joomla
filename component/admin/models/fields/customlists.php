<?php

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('list');

class JFormFieldCustomlists extends JFormFieldList
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'CustomLists';

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

        foreach ($scoutgroup->customLists as $customlist) {
            $options[] = JHtmlSelect::option("{$customlist->source}:{$customlist->id}", $customlist->title);
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
