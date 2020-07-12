<?php

use Joomla\CMS\Language\Text;

class ScoutorgHelper
{
    /**
     * Parses a string containing source and id for an scoutorg object.
     * Returns an associated array with format:
     *      source : string         The source of the object
     *      id     : int|string     The id of the object
     * @param string $id 
     * @return false|string[] 
     */
    public static function parseFieldId($id)
    {
        $splitId = \explode(':', $id);
        if (count($splitId) !== 2) {
            return false;
        }
        return ['source' => $splitId[0], 'id' => $splitId[1]];
    }

    /**
     * Generates a sidebar for all pages.
     * @param string $view The view name. Is hardcoded.
     * @return string
     */
    public static function addSubMenu(string $view)
    {
        JHtmlSidebar::addEntry(
            Text::_('COM_SCOUTORG_ADMIN_BRANCHES'),
            'index.php?option=com_scoutorg&view=branches',
            $view == 'branches'
        );
        JHtmlSidebar::addEntry(
            Text::_('COM_SCOUTORG_ADMIN_TROOPS'),
            'index.php?option=com_scoutorg&view=troops',
            $view == 'troops'
        );
        JHtmlSidebar::addEntry(
            Text::_('COM_SCOUTORG_ADMIN_USERPROFILEFIELDS'),
            'index.php?option=com_scoutorg&view=userprofilefields',
            $view == 'userprofilefields'
        );
        return JHtmlSidebar::render();
    }

    /**
     * Evaluates fieldtype name for given fieldtype
     * @param string $field field type name
     * @return string|false
     */
    public static function evalFieldname(string $field)
    {
        if ($field === 'org-id') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_ID');
        } elseif ($field === 'org-fullname') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_FULLNAME');
        }
        elseif ($field === 'org-firstname') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_FIRSTNAME');
        }
        elseif ($field === 'org-lastname') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_LASTNAME');
        }
        elseif ($field === 'org-age') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_AGE');
        }
        elseif ($field === 'org-birthdate') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_BIRTHDATE');
        }
        elseif ($field === 'org-gender') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_GENDER');
        }
        elseif ($field === 'org-ssno') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_SSNO');
        }
        elseif ($field === 'org-home') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_HOME');
        }
        elseif ($field === 'org-emails') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_EMAILS');
        }
        elseif ($field === 'org-telnrs') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_TELNRS');
        }
        elseif ($field === 'org-startdate') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_STARTDATE');
        }
        elseif ($field === 'org-contacts') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_CONTACTS');
        }
        elseif ($field === 'org-troops') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_TROOPS');
        }
        elseif ($field === 'org-rolegroups') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_ROLEGROUPS');
        }
        elseif ($field === 'org-code') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_CODE');
        }
        else {
            return false;
        }
    }
}
