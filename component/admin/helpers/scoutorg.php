<?php

use Joomla\CMS\Language\Text;

class ScoutorgHelper
{
    /**
     * Generates a sidebar for all pages.
     * @param string $view The view name. Is hardcoded.
     * @return string
     */
    public static function addSubMenu(string $view)
    {
        JHtmlSidebar::addEntry(
            Text::_('COM_SCOUTORG_ADMIN_BRANCHES'),
            'index.php?option=com_scoutorg&view=orgobjects&type=branch',
            $view == 'branch'
        );
        JHtmlSidebar::addEntry(
            Text::_('COM_SCOUTORG_ADMIN_TROOPS'),
            'index.php?option=com_scoutorg&view=orgobjects&type=troop',
            $view == 'troop'
        );
        JHtmlSidebar::addEntry(
            Text::_('Group Roles'),
            'index.php?option=com_scoutorg&view=orgobjects&type=grouprole',
            $view == 'grouprole'
        );
        JHtmlSidebar::addEntry(
            Text::_('Members'),
            'index.php?option=com_scoutorg&view=orgobjects&type=groupmember',
            $view == 'member'
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
        } elseif ($field === 'org-firstname') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_FIRSTNAME');
        } elseif ($field === 'org-lastname') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_LASTNAME');
        } elseif ($field === 'org-age') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_AGE');
        } elseif ($field === 'org-birthdate') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_BIRTHDATE');
        } elseif ($field === 'org-gender') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_GENDER');
        } elseif ($field === 'org-ssno') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_SSNO');
        } elseif ($field === 'org-home') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_HOME');
        } elseif ($field === 'org-emails') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_EMAILS');
        } elseif ($field === 'org-telnrs') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_TELNRS');
        } elseif ($field === 'org-startdate') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_STARTDATE');
        } elseif ($field === 'org-contacts') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_CONTACTS');
        } elseif ($field === 'org-troops') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_TROOPS');
        } elseif ($field === 'org-rolegroups') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_ROLEGROUPS');
        } elseif ($field === 'org-code') {
            return Text::_('COM_SCOUTORG_USERPROFILEFIELD_FIELD_CODE');
        } else {
            return false;
        }
    }
}
