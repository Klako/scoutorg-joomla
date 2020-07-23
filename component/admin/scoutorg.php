<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die('Restricted access');

if (!Factory::getUser()->authorise('core.manage', 'com_scoutorg')) {
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::register('ScoutorgHelper', JPATH_COMPONENT . '/helpers/scoutorg.php');

$input = Factory::getApplication()->input;

$controller = BaseController::getInstance('ScoutOrg');
$controller->execute($input->getCmd('task'));

$controller->redirect();
