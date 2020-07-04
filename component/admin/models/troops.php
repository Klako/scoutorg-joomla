<?php

use Joomla\CMS\MVC\Model\ListModel;

class ScoutOrgModelTroops extends ListModel {
    /**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = \Joomla\CMS\Factory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')->from($db->quoteName('#__scoutorg_troops'));

		return $query;
	}
}
