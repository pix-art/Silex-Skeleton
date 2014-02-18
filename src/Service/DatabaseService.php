<?php

namespace Service;

use Doctrine\DBAL\Connection;
use Model\BaseModel;

class DatabaseService
{

    private $db;
    private $dbName;

    public function __construct(Connection $db, $dbName)
    {
        $this->db = $db;
        $this->dbName = $dbName;
    }

    public function insert(BaseModel $model)
    {
        $dbData = $model->toColumn();

        $this->db->insert($this->dbName, $dbData);

        return $this->db->lastInsertId();
    }

    public function load(BaseModel $model)
    {
        $id = $model->getId();

        $sql = "SELECT * FROM $this->dbName WHERE ID = ?";
        $data = $this->db->fetchAssoc($sql, array((int) $id));

        if (empty($data)) {
            throw new ValidationException(array('id'=>'invalid_id'));
        }

        $model->fromColumn($data);

        return $model;
    }

    public function update(BaseModel $model)
    {
        $dbData = $model->toColumn();
        $id = $model->getId();

        $this->db->update($this->dbName, $dbData, array('ID' => $id));
    }

}
