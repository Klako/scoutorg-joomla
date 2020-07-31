<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Scouterna\Scoutorg\Model\OrgArray;
use Scouterna\Scoutorg\Model\OrgObject;

require_once 'duallist.php';

class JFormFieldOrgArraySelect extends JFormFieldDuallist
{
    protected $relation = 'manytomany';
    protected $forceMultiple = true;

    public function setup(\SimpleXMLElement $element, $value, $group = null)
    {
        /** @var FormField $this */
        $result = parent::setup($element, $value, $group);
        if ($result) {
            $this->relation = $this->element['relation'] ?: 'manytomany';
        }
        return $result;
    }

    protected function getOptions()
    {
        $options = [];

        if ($this->relation == 'manytomany') {
            [$superArray, $subArray, $textFunc] = $this->value;
            /** @var OrgArray<OrgObject> $superArray */
            /** @var OrgArray<OrgObject> $subArray */
            /** @var callable $textFunc */
            foreach ($superArray as $orgObject) {
                $text = $textFunc($orgObject);
                $selected = '';
                $disabled = '';
                if ($subArray->exists($orgObject->uid)) {
                    $selected = 'selected';
                    if (!in_array('joomla', $subArray->sourcesOf($orgObject->uid))) {
                        $disabled = 'disabled';
                    }
                }
                $options[] = "<option value='{$orgObject->uid->serialize()}' $selected $disabled>$text</option>";
            }
        } elseif ($this->relation == 'onetomany') {
            [$superArray, $subArray, $textFunc, $reverseProperty] = $this->value;
            /** @var OrgArray<OrgObject> $superArray */
            /** @var OrgArray<OrgObject> $subArray */
            /** @var callable $textFunc */
            /** @var string $reverseProperty */
            foreach ($superArray as $orgObject) {
                $text = $textFunc($orgObject);
                $selected = '';
                $disabled = '';
                if ($subArray->exists($orgObject->uid)) {
                    $selected = 'selected';
                    if (!in_array('joomla', $subArray->sourcesOf($orgObject->uid))) {
                        $disabled = 'disabled';
                    }
                } elseif ($orgObject->$reverseProperty != null) {
                    $disabled = 'disabled';
                }
                $options[] = "<option value='{$orgObject->uid->serialize()}' $selected $disabled>$text</option>";
            }
        }

        return $options;
    }
}
