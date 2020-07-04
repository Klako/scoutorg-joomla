<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('list');

class JFormFieldBranches extends JFormFieldList
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Branches';

    /**
     * Method to get a list of options for a list input.
     * @return  array  An array of JHtml options.
     */
    protected function getOptions()
    {
        $db    = Factory::getDBO();
        $query = $db->getQuery(true);
        $query->select('id, name');
        $query->from('#__scoutorg_branches');
        
        $db->setQuery((string) $query);
        $results = $db->loadObjectList();
        $options  = array();

        if ($results) {
            foreach ($results as $result) {
                $options[] = HTMLHelper::_('select.option', $result->id, $result->name);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
