<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;

class ScoutorgModelUserprofilefields extends ListModel {
    protected function getListQuery()
	{
		// Initialize variables.
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')->from($db->quoteName('#__scoutorg_userprofilefields'));
		$query->order('ordering ASC');

		return $query;
	}
}