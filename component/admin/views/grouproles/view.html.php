<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * @package Joomla.Administrator
 * @subpackage com_scoutorg
 */

class ScoutOrgViewGrouproles extends HtmlView
{
	/**
	 * Display the branches view
	 * @param string $tpl
	 * @return void
	 */
	function display($tpl = null)
	{
		$this->grouproles = $this->get('Grouproles');

		$this->addToolbar();
		$this->sidebar = ScoutorgHelper::addSubMenu('grouproles');

		parent::display($tpl);

		$this->setDocument();
	}

	private function setDocument()
	{
		$document = Factory::getDocument();
		$document->setTitle(Text::_('COM_SCOUTORG_ADMINISTRATION'));
	}

	private function addToolbar()
	{
		ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
		ToolbarHelper::addNew('grouprole.add');
		ToolbarHelper::deleteList('', 'grouprole.delete');
	}
}
