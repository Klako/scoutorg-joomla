<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die('Restricted access');

JLoader::register('ScoutOrgHelper', JPATH_COMPONENT . '/helpers/scoutorg.php');

$controller = BaseController::getInstance('ScoutOrg');

$input = Factory::getApplication()->input;
$controller->execute($input->getCmd('task'));

$controller->redirect();