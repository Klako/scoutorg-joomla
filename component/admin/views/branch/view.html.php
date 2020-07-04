<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class ScoutOrgViewBranch extends HtmlView
{
    protected $form;
    protected $item;

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
        $this->item = $this->get('Item');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        $input = Factory::getApplication()->input;

        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

        ToolbarHelper::title($isNew ? Text::_('COM_SCOUTORG_MANAGER_BRANCH_NEW')
                                     : Text::_('COM_SCOUTORG_MANAGER_BRANCH_EDIT'), 'branch');
        // Build the actions for new and existing records.
        
        ToolBarHelper::apply('branch.apply', 'JTOOLBAR_APPLY');
        ToolBarHelper::save('branch.save', 'JTOOLBAR_SAVE');

        if ($isNew) {
            ToolBarHelper::cancel('branch.cancel', 'JTOOLBAR_CANCEL');
        } else {
            ToolBarHelper::cancel('branch.cancel', 'JTOOLBAR_CLOSE');
        }
    }
    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $isNew = ($this->item->id == 0);
        $document = Factory::getDocument();
        $document->setTitle($isNew ? Text::_('COM_SCOUTORG_MANAGER_BRANCH_NEW')
                                   : Text::_('COM_SCOUTORG_MANAGER_BRANCH_EDIT'));
        $document->addScript(__DIR__.'/submitbutton.js');
        Text::script('COM_SCOUTORG_ERROR_INVALIDINPUT');
    }
}
