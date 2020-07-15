<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;
use Scouterna\Scoutorg\Builder\Uid;

class ScoutOrgModelBranches extends BaseDatabaseModel
{
	public function getBranches()
	{
		jimport('scoutorg.loader');
		$scoutgroup = ScoutorgLoader::loadGroup();

		return $scoutgroup->branches;
	}

	/**
	 * @inheritdoc
	 * @return Table
	 */
	public function getTable($name = 'Branch', $prefix = 'ScoutOrgTable', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}

	/**
	 * Deletes all branches with the specified uids.
	 * @param string[] $uids 
	 * @return int|bool
	 * @throws Exception 
	 * @throws InvalidArgumentException 
	 * @throws RuntimeException 
	 * @throws UnexpectedValueException 
	 */
	public function delete($uids)
	{
		jimport('scoutorg.loader');
		/** @var CMSObject|ScoutOrgModelBranches $this */
		/** @var CMSObject|Table $table */

		$table = $this->getTable();

		foreach ($uids as $i => $uid) {
			$uid = Uid::deserialize($uid);

			if (!$this->isLocal($uid)) {
				unset($uids[$i]);
				Log::add(Text::_('COM_SCOUTORG_CANNOT_DELETE_REMOTE_ORGOBJECT'), Log::ERROR);
				continue;
			}
			if (!$table->load($uid->getId())) {
				unset($uids[$i]);
				Log::add($table->getError(), Log::ERROR);
				continue;
			}
			if (!$this->isAuthorised($table)) {
				unset($uids[$i]);
				Log::add(Text::_('JLIB_APPLICATION_ERROR_DELETE_NOT_PERMITTED', Log::WARNING, 'jerror'));
				continue;
			}
			if (!$table->delete($uid->getId())) {
				unset($uids[$i]);
				Log::add($table->getError(), Log::ERROR);
				continue;
			}
		}

		return true;
	}

	/**
	 * @param Uid $uid 
	 * @return return bool 
	 */
	protected function isLocal($uid)
	{
		return $uid->getSource() == 'joomla';
	}

	protected function isAuthorised($table)
	{
		return Factory::getUser()->authorise('core.delete', $this->option);
	}
}
