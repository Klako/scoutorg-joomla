<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die('Restricted access');

FormHelper::loadFieldClass('subform');

class JFormFieldOrgobjectsubform extends JFormFieldSubform
{
    /**
     * The field type.
     * @var         string
     */
    protected $type = 'Orgobjectsubform';

    protected function getInput()
    {
        /** @var \Joomla\CMS\Document\Document $document */
        $document = Factory::getDocument();
        $document->addScript(Uri::root() . 'media/com_scoutorg/js/jquery.quicksearch.js');

        /** @var JFormFieldOrgobjectsubform|FormField $this */
        $this->buttons = $this->form->subformbuttons;

        $html = [];

        $filterText = Text::_('Filter');

        $html[] = <<<HTML
        <input type="text" id="{$this->fieldname}-search" placeholder="{$filterText}" />
        <span id="{$this->fieldname}-search-label">No results</span>
        HTML;

        $html[] = parent::getInput();

        $html[] = <<<HTML
        <script>
            (function(){
                let searchBox = jQuery("#patrols-search");
                let resultBox = jQuery('#{$this->fieldname}-search-label');
                let search = jQuery("#{$this->fieldname}-search").quicksearch('#patrols-search ~ div table > tbody > tr', {
                    onBefore: () => {
                        search.cache();
                    },
                    testQuery: (query, txt, row) => {
                        for (var i = 0; i < query.length; i += 1) {
                            var foundInValue = false;
                            var inputs = jQuery(row).find('input');
                            for (var j = 0; j < inputs.length; j += 1) {
                                if (jQuery(inputs[j]).is(':hidden')){
                                    continue;
                                }
                                if (inputs[j].value.toLowerCase().indexOf(query[i]) !== -1) {
                                    foundInValue = true;
                                    break;
                                }
                            }
                            if (!(txt.indexOf(query[i]) !== -1 || foundInValue)) {
                                return false;
                            }
                        }
                        return true;
                    }
                });
                search.cache();
            })();
        </script>
        HTML;

        return implode('', $html);
    }
}
