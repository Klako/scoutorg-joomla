<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;

class ScoutOrgTableBranchtroop extends Table
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    public function __construct(&$db)
    {
        parent::__construct('#__scoutorg_branchtroops', 'id', $db);
    }

    public function check()
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true);

        $query->select('troop')
            ->from($this->getTableName())
            ->where("{$query->qn('troop')} = {$db->quote($this->troop)}");
        $db->setQuery($query);

        if (($result = $db->loadNextObject()) && $result->troop != $this->troop) {
            /** @var CMSObject $this */
            $this->setError('Duplicate troop');
            return false;
        }

        return true;
    }
}
