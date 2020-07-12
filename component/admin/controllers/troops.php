<?php

use Joomla\CMS\MVC\Controller\AdminController;

class ScoutOrgControllerTroops extends AdminController
{
	public function getModel($name = 'Troop', $prefix = 'ScoutOrgModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}
