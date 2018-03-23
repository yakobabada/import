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
     * @return mixed
     */
    abstract public function save();

    /**
     * @param int $id
     *
     * @return mixed
     */
    abstract public function find(int $id);
}