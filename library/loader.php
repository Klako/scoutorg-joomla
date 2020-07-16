<?php
/**
 * Contains ScoutOrgLoader class
 * @author Alexander Krantz
 */

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Scouterna\Scoutorg\Builder;
use Scouterna\Scoutorg\Lib\ScoutGroup;
use Scouterna\Scoutorg\Scoutnet;
use Scouterna\Scoutorg\Joomorg;
use Scouterna\Scoutorg\Model\Uid;

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

        $uid = new Uid('scoutnet', self::$groupId);

        return $builder->scoutGroups->get($uid);
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

        $joomlaProvider = new Joomorg\PartProvider(Factory::getDbo());

        $builderConfig = new Builder\Config();
        $builderConfig->addProvider('joomla', $joomlaProvider);
        $builderConfig->addProvider('scoutnet', $scoutnetProvider);

        self::$builder = new Builder\ScoutorgBuilder($builderConfig);

        return self::$builder;
    }

    /**
     * Gets the component params.
     * @return Registry
     */
    private static function getParams() {
        return ComponentHelper::getParams('com_scoutorg');
    }
}