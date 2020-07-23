<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * @package Joomla.Administrator
 * @subpackage com_scoutorg
 */

class ScoutOrgViewOrgobjects extends HtmlView
{
    protected $table;

    /**
     * Display the branches view
     * @param string $tpl
     * @return void
     */
    function display($tpl = null)
    {
        $app = Factory::getApplication();

        $this->type = strtolower($app->input->getString('type'));
        if (!$this->type) {
            $app->enqueueMessage('Missing type parameter', 'error');
            return;
        }

        /** @var OrgObjectsModel */
        $model = $this->getModel();
        if (!($model instanceof OrgObjectsModel)) {
            $app->enqueueMessage('Bad type parameter', 'error');
            return;
        }

        $this->table = $model->getTable();

        $this->addToolbar();
        $this->sidebar = ScoutorgHelper::addSubMenu($this->type);

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
        ToolbarHelper::addNew("{$this->type}.add");
        ToolbarHelper::deleteList('', "{$this->type}.delete");
    }
}
