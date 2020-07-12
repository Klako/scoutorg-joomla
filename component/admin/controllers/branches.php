<?php

use Joomla\CMS\MVC\Controller\AdminController;

class ScoutOrgControllerBranches extends AdminController
{
	public function getModel($name = 'Branches', $prefix = 'ScoutOrgModel', $config = array())
	{
		return parent::getModel($name, $prefix, $config);
	}
}
