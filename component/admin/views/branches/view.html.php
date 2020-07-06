<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * @package Joomla.Administrator
 * @subpackage com_scoutorg
 */

class ScoutOrgViewBranches extends HtmlView {
    /**
	 * Display the branches view
	 * @param string $tpl
	 * @return void
	 */
	function display($tpl = null) {
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		$this->addToolbar();
		$this->sidebar = ScoutOrgHelper::addSubMenu('branches');

		parent::display($tpl);

		$this->setDocument();
	}

	private function setDocument() {
		$document = Factory::getDocument();
		$document->setTitle(Text::_('COM_SCOUTORG_ADMINISTRATION'));
	}

	private function addToolbar() {	
		ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
		ToolbarHelper::addNew('branch.add');
		ToolbarHelper::editList('branch.edit');
		ToolbarHelper::deleteList('', 'branches.delete');
	}
}