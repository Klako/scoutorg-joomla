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

class ScoutOrgViewBranches extends HtmlView
{
	/**
	 * Display the branches view
	 * @param string $tpl
	 * @return void
	 */
	function display($tpl = null)
	{
		$this->branches = $this->get('Branches');

		$this->addToolbar();
		$this->sidebar = ScoutorgHelper::addSubMenu('branches');

		parent::display($tpl);

		$this->setDocument();
	}

	private function setDocument()
	{
		$document = Factory::getDocument();
		$document->setTitle(Text::_('COM_SCOUTORG_ADMINISTRATION'));
		$document->addScript('/media/com_scoutorg/js/modalCloseBehaviour.js');
	}

	private function addToolbar()
	{
		ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
		ToolbarHelper::addNew('branch.add');
		ToolbarHelper::deleteList('', 'branch.delete');
	}
}
