<?php

use Joomla\CMS\Document\Document;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die('Restricted access');

abstract class JFormFieldDuallist extends FormField
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Duallist';

    protected abstract function getOptions();

    protected function getInput()
    {
        JHtmlJquery::framework();
        /** @var Document */
        $document = Factory::getDocument();
        $document->addScript(Uri::root() . 'media/com_scoutorg/js/jquery.multi-select.min.js');
        $document->addScript(Uri::root() . 'media/com_scoutorg/js/jquery.quicksearch.js');
        $document->addStyleSheet(Uri::root() . 'media/com_scoutorg/css/multi-select.min.css');

        $filterText = Text::_('Filter');
        $selectableText = Text::_('Selectable');
        $selectionText = Text::_('Selection');

        $script = <<<JS
        <script lang="text/javascript">
            (function(){
                    jQuery("#{$this->id}").multiSelect({
                        selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='$filterText'>",
                        selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='$filterText'>",
                        selectableFooter: "<div class='text-center'><strong>$selectableText</strong></div>",
                        selectionFooter: "<div class='text-center'><strong>$selectionText</strong></div>",
                        afterInit: function (ms) {
                            var that = this,
                                selectableSearch = that.\$selectableUl.prev(),
                                selectionSearch = that.\$selectionUl.prev(),
                                selectableSearchString = '#' + that.\$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                                selectionSearchString = '#' + that.\$container.attr('id') + ' .ms-elem-selection.ms-selected';
                            that.qs1 = selectableSearch.quicksearch(selectableSearchString);
                            that.qs2 = selectionSearch.quicksearch(selectionSearchString);
                        },
                        afterSelect: function () {
                            this.qs1.cache();
                            this.qs2.cache();
                        },
                        afterDeselect: function () {
                            this.qs1.cache();
                            this.qs2.cache();
                        }
                    });
            })();
        </script>
        JS;

        $select = "<select id='{$this->id}' name='{$this->name}' multiple>";
        $select .= implode('', $this->getOptions());
        $select .= '</select>';

        return <<<HTML
            $select
            $script
        HTML;
    }
}
