<?php

class FileModel extends AbstractModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return FileModel
     */
    private function setId(int $id): FileModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FileModel
     */
    public function setName(string $name): FileModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $this->databaseManager->query('INSERT INTO file (name) VALUE (?)', $this->getName());

        return $this->find($this->databaseManager->lastInsertId());
    }

    /**
     * @inheritdoc
     */
    public function find(int $id): FileModel
    {
        $result = $this->databaseManager->query('select * from file where id = ?', $id)->fetch(PDO::FETCH_ASSOC);

        return $this->map($result);
    }

    /**
     * @inheritdoc
     */
    protected function map($result)
    {
        return $this
            ->setId($result['id'])
            ->setName($result['name']);
    }
}