<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Router\Route;

abstract class OrgObjectController extends BaseController
{
    protected $context;

    protected $option;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->option = 'com_scoutorg';

        if (empty($this->context)) {
            $r = null;
            if (!preg_match('/(.*)Controller(.*)/i', get_class($this), $r)) {
                throw new \Exception(Text::_('JLIB_APPLICATION_ERROR_CONTROLLER_GET_NAME'), 500);
            }
            $this->context = strtolower($r[2]);
        }

        $this->registerTask('apply', 'save');
    }

    protected abstract function getListViewName();


    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
    {
        if (empty($name)) {
            $name = $this->context;
        }

        return parent::getModel($name, $prefix, $config);
    }

    public function add()
    {
        $context = "$this->option.edit.$this->context";

        Factory::getApplication()->setUserState("$context.data", null);

        $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}", false));

        return true;
    }

    public function edit()
    {
        $context = "$this->option.edit.$this->context";

        Factory::getApplication()->allowCache(false);
        Factory::getApplication()->setUserState("$context.data", null);

        $uid = Factory::getApplication()->input->getString('uid');

        $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}&uid=$uid", false));

        return true;
    }

    public function save()
    {
        $this->checkToken();

        $app   = Factory::getApplication();
        $data  = $this->input->post->get('jform', array(), 'array');
        $context = "$this->option.edit.$this->context";
        $uid = $data['uid'];

        /** @var OrgObjectModel|CMSObject */
        $model = $this->getModel();
        $form = $model->getForm($data, false);

        if (!$form) {
            $app->enqueueMessage($model->getError(), 'error');
            return false;
        }

        $validData = $model->validate($form, $data);

        if ($validData === false) {
            $app->enqueueMessage($model->getError(), 'error');
            $app->setUserState("$context.data", $data);
            if ($uid) {
                $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}&uid=$uid", false));
            } else {
                $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}", false));
            }
            return false;
        }

        if (!$model->save($validData)) {
            $app->enqueueMessage($model->getError(), 'error');
            $app->setUserState("$context.data", $data);
            if ($uid) {
                $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}&uid=$uid", false));
            } else {
                $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}", false));
            }
            return false;
        }

        $this->setMessage('Save success');

        if ($this->task == 'save') {
            $app->setUserState("$context.data", null);
            $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->getListViewName()}", false));
        } else {
            $app->setUserState("$context.data", null);
            $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->context}&uid={$model->getState($this->context . '.id')}", false));
        }

        return true;
    }

    public function cancel()
    {
        $this->checkToken();
        $context = "$this->option.edit.$this->context";

        Factory::getApplication()->setUserState("$context.data", null);

        $this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->getListViewName()}", false));
    }

    public function delete()
	{
		// Check for request forgeries
		$this->checkToken();

		// Get items to remove from the request.
		$cid = $this->input->get('cid', array(), 'array');

		if (!is_array($cid) || count($cid) < 1) {
			Log::add(Text::_('COM_SCOUTORG_NO_ITEM_SELECTED'), Log::WARNING, 'jerror');
		} else {
			// Get the model.
			$model = $this->getModel();

			// Remove the items.
			if ($model->delete($cid)) {
				$this->setMessage(Text::plural('COM_SCOUTORG_N_ITEMS_DELETED', count($cid)));
			} else {
				$this->setMessage($model->getError(), 'error');
			}
		}

		$this->setRedirect(Route::_("index.php?option=com_scoutorg&view={$this->getListViewName()}", false));
	}
}
