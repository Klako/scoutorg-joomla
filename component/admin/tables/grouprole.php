<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;

class ScoutOrgTableGrouprole extends Table
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__scoutorg_grouproles', 'id', $db);
	}

	public function check()
	{
		if (trim($this->name) == '') {
			/** @var CMSObject $this */
			$this->setError(Text::_('COM_SCOUTORG_ERROR_MISSINGNAME'));
			return false;
		}

		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id')
			->from('#__scoutorg_grouproles')
			->where("`name` = {$db->quote($this->name)}");
		$db->setQuery($query);

		if (($result = $db->loadNextObject()) && $result->id != $this->id) {
			/** @var CMSObject $this */
			$this->setError(Text::_('COM_SCOUTORG_ERROR_DUPLICATENAME'));
			return false;
		}

		return true;
	}
}
