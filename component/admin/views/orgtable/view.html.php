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

class ScoutOrgViewOrgtable extends HtmlView
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

        $this->sidebar = ScoutorgHelper::addSubMenu('orgtable');

        /** @var ScoutOrgModelOrgtable */
        $model = $this->getModel();

        $this->tree = $model->getTree();

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
        $document->addScript(Uri::root() . 'media/com_scoutorg/js/jquery.treetable.js');
        $document->addStyleSheet(Uri::root() . 'media/com_scoutorg/css/jquery.treetable.css');
        $document->addStyleSheet(Uri::root() . 'media/com_scoutorg/css/jquery.treetable.theme.orgtable.css');
        $document->addScriptDeclaration(<<<'JS'
            jQuery(document).ready(function() {
                
            });
        JS);
    }

    private function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_SCOUTORG_ADMINISTRATION'), 'generic.png');
    }

    public function printTreeNodes($nodeList, $parent, $depth = 0)
    {
        $html = [];
        $prefix = str_repeat('-', $depth);
        foreach ($nodeList as $id => $node) {
            $html[] = <<<HTML
            <tr data-tt-id="{$id}" data-tt-parent-id="{$parent}" data-tt-branch="{$node['force']}">
                <td>{$prefix} {$node['name']}</td>
                <td>{$node['type']}</td>
                <td>{$node['uid']}</td>
                <td>{$node['actions']}</td>
            </tr>
            HTML;
            $html[] = $this->printTreeNodes($node['children'], $id, $depth + 1);
        }
        return implode('', $html);
    }
}
