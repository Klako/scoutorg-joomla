<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * @package Joomla.Administrator
 * @subpackage com_scoutorg
 */

class ScoutOrgViewTroops extends HtmlView {
    /**
	 * Display the troops view
	 * @param string $tpl
	 * @return void
	 */
	function display($tpl = null) {
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		jimport('scoutorg.loader');
		$this->scoutgroup = ScoutorgLoader::loadGroup();

		$this->addToolbar();
		$this->sidebar = ScoutorgHelper::addSubMenu('troops');

		parent::display($tpl);

		$this->setDocument();
	}

	private function setDocument() {
		$document = Factory::getDocument();
		$document->setTitle(Text::_('COM_SCOUTORG_ADMINISTRATION'));
	}

	private function addToolbar() {	
		ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
		ToolBarHelper::addNew('troop.add');
		ToolBarHelper::deleteList('', 'troop.delete');
	}
}