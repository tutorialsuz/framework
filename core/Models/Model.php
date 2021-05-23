<?php

namespace Core\Models;

use ReflectionException;

class Model extends BaseModel
{
    /**
     * @var bool
     */
    private $statement;

    /**
     * @param array $params
     * @return void
     * @throws ReflectionException
     */
    public function create(array $params)
    {
        $statement = $this->prepare($this->createSqlQuery($params));
        $statement->execute($this->values($params));
    }

    /**
     * @return mixed|void
     */
    public function all()
    {
        return $this->query($this->createSqlQuery([], 'all'))->fetchAll();
    }

    /**
     * @param $condition
     * @return mixed|void
     * @throws ReflectionException
     */
    public function where(array $condition)
    {
        $statement = $this->prepare($this->createSqlQuery($condition, 'where'));
        $statement->execute($this->placeholderize($condition));
        $this->statement = $statement;
        return $this;
    }

    /**
     * @param int $id
     * @return mixed|void
     */
    public function find(int $id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @return mixed|void
     */
    public function get()
    {
        $this->statement->setFetchMode(self::FETCH_CLASS, $this->reflection->name);
        return $this->statement->fetchAll();
    }

    /**
     * @return mixed|void
     */
    public function first()
    {
        $this->statement->setFetchMode(self::FETCH_CLASS, $this->reflection->name);
        return $this->statement->fetch();
    }

    /**
     * @param array $params
     * @return mixed|void
     */
    public function update(array $params)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param array|null $condition
     * @return mixed|void
     */
    public function delete(array $condition)
    {
        $statement = $this->prepare($this->createSqlQuery($condition, 'delete'));
        $statement->execute($this->placeholderize($condition));
    }
}