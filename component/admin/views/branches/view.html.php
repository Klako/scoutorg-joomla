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
		//$this->setModel('ScoutorgModelBranch');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->modal 		= $this->modal();

		$this->addToolbar();
		$this->sidebar = ScoutOrgHelper::addSubMenu('branches');

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
		ToolbarHelper::modal('BranchModal', 'icon-new', 'JTOOLBAR_NEW');
		ToolbarHelper::editList('branch.edit');
		ToolbarHelper::deleteList('', 'branches.delete');
	}

	private function modal()
	{
		$branchLink = Route::_('index.php?option=com_scoutorg&task=branch.edit&id=0&tmpl=component&layout=modal');

		HTMLHelper::_('script', 'system/modal-fields-uncompressed.js', array('version' => 'auto', 'relative' => true));

		$html = JHtmlBootstrap::renderModal(
			'BranchModal',
			[
				'title' => Text::_('COM_SCOUTORG_MANAGER_BRANCH_NEW'),
				'url' => $branchLink,
				'height' => '400px',
				'modalWidth' => '30',
				'footer' => '<button class="btn" aria-hidden="true"'
					. " onclick=\"window.processModalEdit(this, 0, 'add', 'branch', 'cancel', 'adminForm');\">"
					. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
					. '<button class="btn btn-primary" aria-hidden="true"'
					. " onclick=\"window.processModalEdit(this, 0, 'add', 'branch', 'save', 'adminForm');setTimeout('window.location.reload()',100);\">"
					. Text::_('JSAVE') . '</button>'
			]
		);
		return $html;
	}
}
