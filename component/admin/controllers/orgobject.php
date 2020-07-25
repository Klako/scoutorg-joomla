<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Router\Route;
use Scouterna\Scoutorg\Model\Uid;

abstract class OrgObjectController extends BaseController
{
    protected $type;

    protected $option;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->option = 'com_scoutorg';

        if (empty($this->type)) {
            $r = null;
            if (!preg_match('/(.*)Controller(.*)/i', get_class($this), $r)) {
                throw new \Exception(Text::_('JLIB_APPLICATION_ERROR_CONTROLLER_GET_NAME'), 500);
            }
            $this->type = strtolower($r[2]);
        }

        $this->registerTask('apply', 'save');
    }

    public function getModel($name = '', $prefix = 'ScoutOrgModel', $config = array('ignore_request' => true))
    {
        if (empty($name)) {
            $name = $this->type;
        }

        return parent::getModel($name, $prefix, $config);
    }

    public function add()
    {
        $context = "$this->option.edit.$this->type";

        Factory::getApplication()->setUserState("$context.data", null);

        $this->setRedirectToView();

        return true;
    }

    public function edit()
    {
        $context = "$this->option.edit.$this->type";

        Factory::getApplication()->allowCache(false);
        Factory::getApplication()->setUserState("$context.data", null);

        $uid = Factory::getApplication()->input->getString('uid');

        $this->setRedirectToView($uid);

        return true;
    }

    public function save()
    {
        $this->checkToken();

        $app   = Factory::getApplication();
        $data  = $this->input->post->get('jform', array(), 'array');
        $context = "$this->option.edit.$this->type";
        $serializedUid = $data['uid'];

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
            $this->setRedirectToView($serializedUid);
            return false;
        }

        jimport('scoutorg.loader');
        $uid = Uid::deserialize($serializedUid);
        if (!$model->save($uid, $validData)) {
            $app->enqueueMessage($model->getError(), 'error');
            $app->setUserState("$context.data", $data);
            $this->setRedirectToView($serializedUid);
            return false;
        }

        $this->setMessage('Save success');

        if ($this->task == 'save') {
            $app->setUserState("$context.data", null);
            $this->setRedirectToList();
        } else {
            $app->setUserState("$context.data", null);
            $this->setRedirectToView($uid->serialize());
        }

        return true;
    }

    public function cancel()
    {
        $this->checkToken();
        $context = "{$this->option}.edit.{$this->type}";

        Factory::getApplication()->setUserState("$context.data", null);

        $this->setRedirectToList();
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
            jimport('scoutorg.loader');
            $uids = [];
            foreach ($cid as $id) {
                $uid = Uid::deserialize($id);
                if ($uid) {
                    $uids[] = $uid;
                }
            }

            /** @var OrgObjectModel|CMSObject */
            $model = $this->getModel();

            // Remove the items.
            if ($model->delete($uids)) {
                $this->setMessage(Text::plural('COM_SCOUTORG_N_ITEMS_DELETED', count($cid)));
            } else {
                $this->setMessage($model->getError(), 'error');
            }
        }

        $this->setRedirectToList();
    }

    private function setRedirectToList()
    {
        $this->setRedirect(Route::_("index.php?option=com_scoutorg&view=orgobjects&type={$this->type}", false));
    }

    private function setRedirectToView($uid = '')
    {
        $url = "index.php?option=com_scoutorg&view=orgobject&type={$this->type}";
        if ($uid) {
            $url .= "&uid={$uid}";
        }
        $this->setRedirect(Route::_($url, false));
    }
}
