<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

class ScoutOrgViewGrouprole extends HtmlView
{
    protected $form;
    protected $grouprole;

    /**
     * Display the Branch view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Get the Data
        $this->form = $this->get('Form');
        $this->grouprole = $this->get('Grouprole');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            Factory::getApplication()->enqueueMessage(implode('<br/>', $errors), 'error');
            return;
        }

        // Set the toolbar
        $this->addToolBar(!isset($this->grouprole));

        // Display the template
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar($isNew)
    {
        $input = Factory::getApplication()->input;

        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);

        ToolbarHelper::title($isNew ? Text::_('New Group Role')
            : Text::_('Edit Group Role'));
        // Build the actions for new and existing records.

        ToolBarHelper::save('grouprole.save', 'JTOOLBAR_SAVE');
        ToolBarHelper::cancel('grouprole.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');

        Text::script('COM_SCOUTORG_ERROR_INVALIDINPUT');
    }
}
