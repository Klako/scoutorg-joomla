<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

class ScoutOrgViewOrgobject extends HtmlView
{
    protected $form;
    protected $type;

    /**
     * Display the Branch view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        // Get the Data
        $this->type = strtolower($app->input->getString('type'));
        if (!$this->type) {
            $app->enqueueMessage('Missing type parameter', 'error');
            return;
        }

        /** @var OrgObjectModel */
        $model = $this->getModel();
        if (!($model instanceof OrgObjectModel)) {
            $app->enqueueMessage('Bad type parameter', 'error');
            return;
        }

        $this->form = $model->getForm();

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            Factory::getApplication()->enqueueMessage(implode('<br/>', $errors), 'error');
            return;
        }

        // Set the toolbar
        $this->addToolBar();

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
    protected function addToolBar()
    {
        $input = Factory::getApplication()->input;

        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);

        $isNew = $input->getString('uid') == '';

        ToolbarHelper::title($isNew ? Text::_('JNEW')
            : Text::_('JGLOBAL_EDIT'), $this->type);
        // Build the actions for new and existing records.

        ToolBarHelper::save("{$this->type}.save", 'JTOOLBAR_SAVE');
        ToolBarHelper::cancel("{$this->type}.cancel", 'JTOOLBAR_CANCEL');

        Text::script('COM_SCOUTORG_ERROR_INVALIDINPUT');
    }
}
