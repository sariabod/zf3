<?php

namespace Blog\Model;

use InvalidArgumentException;
use RuntimeException;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;



class ZendDbSqlRepository implements PostRepositoryInterface
{
    /**
    * @var AdapterInterface
    */
    private $db;

    /**
    * @var HydratorInterface
    */
    private $hydrator;

    /**
    * @var Post
    */
    private $postPrototype;

    public function __construct(AdapterInterface $db,HydratorInterface $hydrator,Post $postPrototype)
    {
          $this->db             = $db;
          $this->hydrator       = $hydrator;
          $this->postPrototype  = $postPrototype;
    }

    /**
     * {@inheritDoc}
     */
    public function findAllPosts()
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('posts');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
          return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        return $resultSet;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findPost($id)
    {
    }
}
