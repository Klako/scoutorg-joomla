<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView;

class ScoutorgViewUserprofile extends HtmlView {
    /** @var \Org\Lib\Member */
    protected $member;
    protected $user;
    protected $fields;

    public function display($tpl = null) {
        jimport('scoutorg.loader');
        $members = ScoutOrgLoader::load()->getScoutGroup()->getMembers();

        $fieldsModel = $this->getModel('Userprofilefields');
        $this->fields = $fieldsModel->getItems();

        $memberId = $this->getMemberId();
        if ($memberId !== null && isset($members[$memberId])) {
            $this->member = $members[$memberId];
        }

        parent::display($tpl);
    }

    private function getMemberId() {
        $input = Factory::getApplication()->input;
        $memberId = $input->get('id', null);
        if (!$memberId) {
            $user = Factory::getUser();
            if ($user->guest) {
                return null;
            }
            return (int)$user->username;
        }
        return (int)$memberId;
    }
}