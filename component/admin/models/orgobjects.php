<?php

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Router\Route;

abstract class OrgObjectsModel extends BaseDatabaseModel
{
    public function getTable()
    {
        $data = [
            'columns' => $this->getColumns(),
            'rows' => $this->getDataRows()
        ];
        return $data;
    }

    protected abstract function getColumns();

    protected abstract function getDataRows();

    protected function linkEditObject($type, $uid, $text)
    {
        $url = Route::_("index.php?option=com_scoutorg&view=orgobject&type=$type&uid={$uid->serialize()}");
        return <<<HTML
            <a href="$url">$text</a>
        HTML;
    }
}
