<?php

abstract class AbstractModel
{
    /**
     * @var DatabaseConnectionManager
     */
    protected $databaseManager;

    public function __construct()
    {
        $this->databaseManager = new DatabaseConnectionManager();
    }

    /**
     * @return FileModel
     */
    abstract public function save();

    /**
     * @param int $id
     *
     * @return FileModel
     */
    abstract public function find(int $id);
}