<?php

use Joomla\CMS\Document\Document;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;

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
        $this->sidebar = ScoutorgHelper::addSubMenu($this->type);

        if (!$this->type) {
            $app->enqueueMessage('Missing type parameter', 'error');
        } else {
            /** @var OrgObjectsModel */
            $model = $this->getModel();
            if (!($model instanceof OrgObjectsModel)) {
                $app->enqueueMessage('Bad type parameter', 'error');
                return;
            }
            $this->table = $model->getTable();
        }

        $this->addToolbar();

        parent::display($tpl);

        $this->setDocument();
    }

    private function setDocument()
    {
        /** @var Document */
        $document = Factory::getDocument();
        $document->setTitle(Text::_('COM_SCOUTORG_ADMINISTRATION'));
        JHtmlJquery::framework();
        $document->addScript(Uri::root() . 'media/com_scoutorg/js/datatables.min.js');
        $document->addStyleSheet(Uri::root() . 'media/com_scoutorg/css/datatables.min.css');
        $document->addScriptDeclaration(<<<'JS'
            jQuery(document).ready(function() {
                jQuery('#scoutorg-table').DataTable({
                    columnDefs: [
                        {
                            className: "dt-head-center dt-body-center",
                            targets: [1],
                            orderable: false
                        },
                        {
                            className: "dt-head-left dt-body-left",
                            targets: "_all"
                        }
                    ]
                });
            });
        JS);
    }

    private function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
        ToolbarHelper::addNew("{$this->type}.add");
        ToolbarHelper::deleteList('', "{$this->type}.delete");
    }
}
