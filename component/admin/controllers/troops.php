<?php

use Joomla\CMS\MVC\Controller\BaseController;

class ScoutOrgControllerTroops extends BaseController
{
	public function getModel($name = 'Troops', $prefix = 'ScoutOrgModel', $config = array())
	{
		return parent::getModel($name, $prefix, $config);
	}
}
