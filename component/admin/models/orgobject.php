<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Object\CMSObject;
use Scouterna\Scoutorg\Model\Uid;

abstract class OrgObjectModel extends FormModel
{
    public function getForm($data = array(), $loadData = true)
    {
        $formName = $this->getName();

        $form = $this->loadForm(
            "com_scoutorg.$formName",
            $formName,
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $type = $this->getName();

        // Check the session for previously entered form data.
        $data = Joomla\CMS\Factory::getApplication()->getUserState(
            "com_scoutorg.edit.$type.data",
            array()
        );

        if (empty($data)) {
            $data = $this->fetchFormData();
        }

        return $data;
    }

    protected abstract function fetchFormData();

    public abstract function save(?Uid &$uid, $data);

    protected function startTransaction()
    {
        $db = Factory::getDbo();
        try {
            $db->transactionStart(true);
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            return false;
        }
        return true;
    }

    protected function newQuery()
    {
        $db = Factory::getDbo();
        return $db->getQuery(true);
    }

    protected function executeQuery($query)
    {
        $db = Factory::getDbo();
        $db->setQuery($query);
        try {
            if (!$db->execute($query)) {
                /** @var CMSObject $this */
                $this->setError($db->getErrorMsg());
                return false;
            }
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            return false;
        }
        return true;
    }

    protected function loadAssoc($query, $key = null)
    {
        $db = Factory::getDbo();
        $db->setQuery($query);
        try {
            $result = $db->loadAssocList($key);
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            return false;
        }
        return $result ?? false;
    }

    protected function endTransaction()
    {
        $db = Factory::getDbo();
        try {
            $db->transactionCommit();
        } catch (RuntimeException $ex) {
            /** @var CMSObject $this */
            $this->setError($ex->getMessage());
            $db->transactionRollback(true);
            return false;
        }
        return true;
    }

    /**
     * Updates or creates an org object with
     * the given data. Sets $uid if one is created.
     * Only runs if uid->source is 'joomla'.
     * @param string $table 
     * @param null|Uid &$uid 
     * @param array $binds 
     * @return bool 
     * @throws RuntimeException 
     */
    protected function syncObjectBase(string $table, ?Uid &$uid, array $binds)
    {
        if ($uid && $uid->getSource() != 'joomla') {
            return true;
        }
        $q = $this->newQuery();
        if ($uid) {
            $q->update($table);
            foreach ($binds as $column => $value) {
                $q->set($q->qn($column) . '=' . $q->q($value));
            }
            $q->where("{$q->qn('id')} = {$q->q($uid->getId())}");
        } else {
            $q->insert($table);
            $values = [];
            foreach ($binds as $column => $value) {
                $q->columns($q->qn($column));
                $values[] = $q->q($value);
            }
            $q->values(implode(',', $values));
        }
        if (!$this->executeQuery($q)) {
            return false;
        }
        if (!$uid) {
            $uid = new Uid('joomla', Factory::getDbo()->insertid());
        }
        return true;
    }

    /**
     * Syncs a org object link table so that a one to 
     * many relation correspond with what's being saved.
     * @param string $table 
     * @param Uid $uid 
     * @param string $fromCol
     * @param string $toCol
     * @param string[] $goalUids
     * @return bool 
     */
    protected function syncObjectLinks(
        string $table,
        Uid $uid,
        string $fromCol,
        string $toCol,
        array $goalUids
    ) {
        $rows = [];
        foreach ($goalUids as $goalUid) {
            if ($goalUid) {
                $rows[] = [
                    $toCol => $goalUid
                ];
            }
        }

        return $this->syncTable($table, $fromCol, $uid->serialize(), $rows, $toCol);
    }

    protected function syncSubObjects(
        string $table,
        string $ownerColumn,
        string $ownerUid,
        array $goalRows,
        array $syncColumns
    ) {
        $rows = [];
        foreach ($goalRows as $goalRow) {
            $row = [];
            foreach ($syncColumns as $column) {
                $row[$column] = $goalRow[$column];
            }
            $rowUid = Uid::deserialize($goalRow['uid']);
            if ($rowUid) {
                if ($rowUid->getSource() != 'joomla') {
                    continue;
                }
                $row['id'] = $rowUid->getId();
            }
            $rows[] = $row;
        }
        return $this->syncTable($table, $ownerColumn, $ownerUid, $rows);
    }

    protected function syncTable(
        string $table,
        string $fixedColumn,
        string $fixedValue,
        array $goalRows,
        string $key = 'id'
    ) {
        $inserts = [];
        $insertsWithoutKey = [];
        $removes = [];

        // Pretend all rows must be inserted.
        // Always insert rows without key.
        foreach ($goalRows as $goalRow) {
            $goalRow[$fixedColumn] = $fixedValue;
            if (isset($goalRow[$key])) {
                $inserts[$goalRow[$key]] = $goalRow;
            } else {
                $insertsWithoutKey[] = $goalRow;
            }
        }

        // Load current rows in the db.
        $q = $this->newQuery();
        $q->from($table)
            ->select('*')
            ->where($q->qn($fixedColumn) . '=' . $q->q($fixedValue));
        if (($currentRows = $this->loadAssoc($q)) === false) {
            return false;
        }
        foreach ($currentRows as $currentRow) {
            $keyValue = $currentRow[$key];
            if (isset($inserts[$keyValue])) {
                unset($inserts[$keyValue]);
            } else {
                $removes[] = $currentRow[$key];
            }
        }

        // Delete rows that exist in db
        // but not in goalRows.
        if (!empty($removes)) {
            $q = $this->newQuery();
            $q->delete($table);
            $q->where($q->qn($fixedColumn) . '=' . $q->q($fixedValue));
            $conditions = [];
            foreach ($removes as $remove) {
                $conditions[] = $q->qn($key) . '=' . $q->q($remove);
            }
            $q->andWhere($conditions);
            if (!$this->executeQuery($q)) {
                return false;
            }
        }

        // Insert rows that exist in 
        // goalRows but not in db.
        foreach ($inserts as $insert) {
            if (!$this->easyInsert($table, $insert)) {
                return false;
            }
        }
        foreach ($insertsWithoutKey as $insert) {
            if (!$this->easyInsert($table, $insert)) {
                return false;
            }
        }

        return true;
    }

    protected function easyInsert($table, $binds)
    {
        $q = $this->newQuery();
        $q->insert($table)
            ->columns(array_map(function ($column) use ($q) {
                return $q->qn($column);
            }, array_keys($binds)))
            ->values(implode(',', array_map(function ($value) use ($q) {
                return $q->q($value);
            }, $binds)));
        if (!$this->executeQuery($q)) {
            return false;
        }
        return true;
    }

    /**
     * @param Uid[] $uids 
     * @return bool 
     */
    public abstract function delete($uids);

    protected function easyDelete($table, $col, $value)
    {
        $q = $this->newQuery();
        $q->delete($table)
            ->where($q->qn($col) . '=' . $q->q($value));
        if (!$this->executeQuery($q)) {
            return false;
        }
        return true;
    }
}
