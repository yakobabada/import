<?php

class DatabaseConnectionManager extends PDO
{
    /**
     * DatabaseConnectionManager constructor.
     *
     * @param null|array $options
     */
    public function __construct($options=null)
    {
        parent::__construct(
            'mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DATABASE_NAME,
            USERNAME,
            PASSWORD,
            $options
        );
    }

    /**
     * @param string $query
     *
     * @return PDOStatement
     */
    public function query(string $query): PDOStatement
    {
        $args = func_get_args();
        array_shift($args);

        $response = parent::prepare($query);
        $response->execute($args);
        return $response;
    }

    /**
     * @param $query
     *
     * @return PDOStatement
     */
    public function insecureQuery($query): PDOStatement
    {
        return parent::query($query);
    }

    /**
     * @inheritdoc
     */
    public function lastInsertId($seqName = NULL)
    {
        return parent::lastInsertId($seqName = NULL);
    }
}