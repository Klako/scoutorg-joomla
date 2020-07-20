<?php

use Joomla\CMS\MVC\Controller\BaseController;

class ScoutOrgControllerBranches extends BaseController
{
	public function getModel($name = 'Branches', $prefix = 'ScoutOrgModel', $config = array())
	{
		return parent::getModel($name, $prefix, $config);
	}
}
