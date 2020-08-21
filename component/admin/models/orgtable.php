<?php

use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Toolbar\ToolbarButton;
use Joomla\CMS\Toolbar\ToolbarHelper;

class ScoutOrgModelOrgtable extends BaseDatabaseModel
{
    public function getTree()
    {
        jimport('scoutorg.loader');
        $scoutGroup = ScoutorgLoader::loadGroup();
        $groupUid = $scoutGroup->uid->serialize();

        $tree = [];

        $tree['branches'] = $this->createRow(Text::_('Branches'), '', '', [$this->actionAdd('branch')]);

        foreach ($scoutGroup->branches as $branchUid => $branch) {
            $branchNode = $this->createRow(
                $this->linkEdit('branch', $branchUid, $branch->name),
                Text::_('Branch'),
                $branchUid,
                [],
            );
            foreach ($branch->troops as $troopUid => $troop) {
                $troopNode = $this->createRow(
                    $this->linkEdit('troop', $troopUid, $troop->name),
                    Text::_('Troop'),
                    $troopUid,
                    [],
                );
                foreach ($troop->patrols as $patrolUid => $patrol) {
                    $patrolNode = $this->createRow(
                        $this->linkEdit('patrol', $patrolUid, $patrol->name),
                        Text::_('Patrol'),
                        $patrolUid,
                        [],
                        false
                    );
                    $troopNode['children']["patrol:$patrolUid"] = $patrolNode;
                }
                $branchNode['children']["troop:$troopUid"] = $troopNode;
            }
            $tree['branches']['children']["branch:$branchUid"] = $branchNode;
        }
        $unassignedTroops = $this->createRow(Text::_('Unassigned troops'));
        foreach ($scoutGroup->troops as $troopUid => $troop) {
            if (!$troop->branch) {
                $troopNode = $this->createRow(
                    $this->linkEdit('troop', $troopUid, $troop->name),
                    Text::_('Troop'),
                    $troopUid,
                    []
                );
                foreach ($troop->patrols as $patrolUid => $patrol) {
                    $patrolNode = $this->createRow(
                        $this->linkEdit('patrol', $patrolUid, $patrol->name),
                        Text::_('Patrol'),
                        $patrolUid,
                        [],
                        false
                    );
                    $troopNode['children']["patrol:$patrolUid"] = $patrolNode;
                }
                $unassignedTroops['children']["troop:$troopUid"] = $troopNode;
            }
        }
        $tree['branches']['children']['unassignedtroops'] = $unassignedTroops;

        $tree['grouproles'] = $this->createRow(Text::_('Group Roles'));
        foreach ($scoutGroup->groupRoles as $groupRoleUid => $groupRole) {
            $groupRoleNode = $this->createRow(
                $this->linkEdit('grouprole', $groupRoleUid, $groupRole->name),
                Text::_('Group Role'),
                $groupRoleUid,
                [],
                false
            );
            $tree['grouproles']['children']["grouprole:$groupRoleUid"] = $groupRoleNode;
        }

        $tree['trooproles'] = $this->createRow(Text::_('Troop Roles'));
        foreach ($scoutGroup->troopRoles as $troopRoleUid => $troopRole) {
            $troopRoleNode = $this->createRow(
                $this->linkEdit('trooprole', $troopRoleUid, $troopRole->name),
                Text::_('Troop Role'),
                $troopRoleUid,
                [],
                false
            );
            $tree['trooproles']['children']["trooprole:$troopRoleUid"] = $troopRoleNode;
        }

        $tree['patrolroles'] = $this->createRow(Text::_('Patrol Roles'));
        foreach ($scoutGroup->patrolRoles as $patrolRoleUid => $patrolRole) {
            $patrolRoleNode = $this->createRow(
                $this->linkEdit('patrolrole', $patrolRoleUid, $patrolRole->name),
                Text::_('Patrol Role'),
                $patrolRoleUid,
                [],
                false
            );
            $tree['patrolroles']['children']["patrolrole:$patrolRoleUid"] = $patrolRoleNode;
        }

        $tree['customlists'] = $this->createRow(Text::_('Custom Lists'));
        foreach ($scoutGroup->customLists as $customListUid => $customList) {
            $customListNode = $this->createRow(
                $this->linkEdit('customlist', $customListUid, $customList->title),
                Text::_('Custom List'),
                $customListUid,
                []
            );
            $tree['customlists']['children']["customlist:$customListUid"] = $customListNode;
        }

        return $tree;
    }

    private function createRow($name, $type = '', $uid = '', $actions = [], $force = true)
    {
        return [
            'name' => $name,
            'type' => $type,
            'uid' => $uid,
            'actions' => implode('', $actions),
            'force' => $force ? 'true' : 'false',
            'children' => []
        ];
    }

    private function linkEdit($type, $uid, $text)
    {
        $url = Route::_("index.php?option=com_scoutorg&view=orgobject&type={$type}&uid={$uid}");
        return <<<HTML
            <a href="$url">$text</a>
        HTML;
    }

    private function actionAdd($type, $params = [])
    {
        $html = [];

        $modalBody = [];

        $html[] = '<form action="index.php?option=com_scoutorg" method="post">';

        $html[] = '<button class="btn btn-small">' . Text::_('Add New') . '</button>';

        $html[] = '<input type="hidden" name="task" value="' . $type . '.add" />';
        $html[] = HTMLHelper::_('form.token');
        $html[] = '</form>';

        return implode('', $html);
    }

    private function actionDelete($type, $uid)
    {
    }
}
