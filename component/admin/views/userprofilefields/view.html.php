<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class ScoutorgViewUserprofilefields extends HtmlView {
	function display($tpl = null) {
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');

		$this->addToolbar();
		$this->sidebar = ScoutOrgHelper::addSubMenu('userprofilefields');

		parent::display($tpl);

		$this->setDocument();
	}

	private function setDocument() {
		$document = Factory::getDocument();
		$document->setTitle(Text::_('COM_SCOUTORG_ADMINISTRATION'));
	}

	private function addToolbar() {	
		ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
		ToolbarHelper::addNew('userprofilefield.add');
		ToolbarHelper::editList('userprofilefield.edit');
		ToolbarHelper::deleteList('', 'userprofilefields.delete');
	}
}