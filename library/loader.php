<?php
/**
 * Contains ScoutOrgLoader class
 * @author Alexander Krantz
 */

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Scouterna\Scoutorg\Builder;
use Scouterna\Scoutorg\Lib\ScoutGroup;
use Scouterna\Scoutorg\Scoutnet;

class ScoutorgLoader {
    /** @var Builder\ScoutorgBuilder Scout organisation instance */
    private static $builder;

    /** @var int */
    private static $groupId;

    /**
     * Loads the scout org group according
     * to the scoutorg component params.
     * @return ScoutGroup
     */
    public static function loadGroup(){
        $builder = self::load();
        if (self::$groupId === null){
            $params = self::getParams();
            self::$groupId = $params->get('scoutnet_groupId', -1);
        }

        if (self::$groupId == -1){
            return false;
        }

        return $builder->scoutGroups->get('scoutnet', self::$groupId);
    }

    /**
     * Loads the scout org instance according to
     * the scoutorg component params and configs.
     * @return Builder\ScoutorgBuilder
     */
    public static function load() {
        if (self::$builder) {
            return self::$builder;
        }
        
        $params = self::getParams();

        $domain = $params->get('scoutnet_domain', 'www.scoutnet.se');
        $groupId = $params->get('scoutnet_groupId', -1);
        $memberListKey = $params->get('scoutnet_memberListApiKey', '');
        $customListsKey = $params->get('scoutnet_customListsApiKey', '');
        $scoutnetCacheLifeTime = $params->get('scoutnet_cacheLifeTime');

        if ($groupId == -1 ||
            $memberListKey == '' ||
            $customListsKey == ''
        ) {
            return false;
        }
        
        $groupConfig = new Scoutnet\ScoutGroupConfig(
            $groupId,
            $memberListKey,
            $memberListKey,
            $customListsKey
        );
        $scoutnetConnection = new Scoutnet\ScoutnetConnection($groupConfig, $domain);
        $scoutnetController = new Scoutnet\ScoutnetController($scoutnetConnection, null, $scoutnetCacheLifeTime);
        $scoutnetProvider = new Scoutnet\PartProvider($scoutnetController);

        $builderConfig = new Builder\Config();
        $builderConfig->addProvider('scoutnet', $scoutnetProvider);

        self::$builder = new Builder\ScoutorgBuilder($builderConfig);

        return self::$builder;
    }

    /**
     * Gets the component params.
     * @return JRegistry
     */
    private static function getParams() {
        return ComponentHelper::getParams('com_scoutorg');
    }

    /**
     * Gets the branch configs from the database.
     * @return \Org\Scoutnet\BranchConfig[]
     */
    private static function getBranchConfigs() {
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);
        $query->select('id, name')->from($db->quoteName('#__scoutorg_branches'));
        $db->setQuery($query);

        $configs = array();
        foreach ($db->loadObjectList() as $branchRow) {
            $query = $db->getQuery(true);
            $query->select('troop')
                ->from($db->quoteName('#__scoutorg_troops'))
                ->where("branch = {$branchRow->id}");
            $db->setQuery($query);

            $troops = array();
            foreach ($db->loadObjectList() as $troopRow) {
                $troops[] = $troopRow->troop;
            }
        }

        return $configs;
    }
}