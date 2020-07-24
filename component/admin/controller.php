<?php

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\View\HtmlView;

/**
 * @package Joomla.Administration
 * @subpackage com_scoutorg
 */

class ScoutOrgController extends BaseController
{
	/**
	 * The default view for the display method.
	 *
	 * @var string
	 * @since 12.2
	 */
	protected $default_view = 'orgobjects';

	public function getModel($name = '', $prefix = '', $config = array())
	{
		if ($name == 'orgobject') {
			$name = $this->input->getString('type');
		} elseif ($name == 'orgobjects') {
			$name = $this->input->getString('type') . 'table';
		}
		return parent::getModel($name, $prefix, $config);
	}
}
