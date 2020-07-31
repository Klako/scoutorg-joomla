<?php

defined('_JEXEC') or die('Restricted access');

require_once 'scoutorgselect.php';

class JFormFieldGroupmembers extends JFormFieldDuallist
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Groupmembers';

    /**
     * Method to get a list of options for a list input.
     * @return  array  An array of JHtml options.
     */
    protected function getOptions()
    {
        jimport('scoutorg.loader');
        $scoutgroup = ScoutorgLoader::loadGroup();

        $options = [];

        foreach ($scoutgroup->members as $groupmember) {
            $name = "{$groupmember->member->personInfo->firstname} {$groupmember->member->personInfo->lastname}";
            $options[] = JHtmlSelect::option($groupmember->uid->serialize(), $name);
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
