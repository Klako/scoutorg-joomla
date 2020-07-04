<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;

class ScoutOrgTableTroop extends Table
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    public function __construct(&$db)
    {
        parent::__construct('#__scoutorg_troops', 'id', $db);
    }

    public function check()
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id, troop')
            ->from($db->quoteName('#__scoutorg_troops'))
            ->where("troop = {$this->troop}");
        $db->setQuery($query);

        if (($result = $db->loadNextObject()) && $result->id != $this->id) {
            /** @var CMSObject $this */
            $this->setError(Text::_('COM_SCOUTORG_ERROR_DUPLICATEID'));
            return false;
        }

        return true;
    }
}
