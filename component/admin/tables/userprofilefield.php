<?php

use Joomla\CMS\Table\Table;

class ScoutorgTableUserprofilefield extends Table
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    public function __construct(&$db)
    {
        parent::__construct('#__scoutorg_userprofilefields', 'id', $db);
    }
}
