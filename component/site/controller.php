<?php

use Joomla\CMS\MVC\Controller\BaseController;

class ScoutOrgController extends BaseController {
    public function display($cachable = false, $urlparams = false) {
        $viewName = $this->input->getCmd('view');
        if ($viewName === "userprofile") {
            $view = $this->getView($viewName, 'html');
            $view->setModel($this->getModel('Userprofilefields', 'ScoutOrgModel'));
        }
        parent::display($cachable, $urlparams);
    }
}