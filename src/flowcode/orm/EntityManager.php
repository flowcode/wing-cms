<?php

namespace flowcode\orm;

use flowcode\orm\builder\MapperBuilder;
use flowcode\orm\builder\QueryBuilder;
use flowcode\orm\domain\Collection;
use flowcode\orm\domain\Relation;
use flowcode\wing\mvc\DataSource;
use flowcode\wing\mvc\Entity;
use flowcode\wing\utils\Pager;

/**
 * Description of EntityManager
 *
 * @author JMA <jaguero@flowcode.com.ar>
 */
class EntityManager {

    private static $instance;
    private $conn;
    private $mappingFilePath;
    private $mapping;

    private function __construct() {
        $this->conn = new DataSource();
        $this->mappingFilePath = dirname(__FILE__) . "/../../../orm-mapping.xml";
        $this->mapping = simplexml_load_file($this->mappingFilePath);
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new EntityManager();
        }
        return self::$instance;
    }

    /**
     * Save or Update an entity according to its mapping.
     * @param type $entity 
     */
    public function save($entity) {
        $mapper = MapperBuilder::buildFromClassName($this->mapping, get_class($entity));
        $id = "";
        if (is_null($entity->getId())) {

            /* insert entity */
            $queryIns = QueryBuilder::buildInsertQuery($entity, $mapper);

            $id = $this->conn->insertSQL($queryIns);
            $entity->setId($id);

            /* relations */
            $queryRel = QueryBuilder::buildRelationQuery($entity, $mapper);
            foreach (explode(";", $queryRel) as $q) {
                if (strlen($q) > 5)
                    $this->conn->executeInsert($q);
            }
        } else {
            $queryUpt = QueryBuilder::buildUpdateQuery($entity, $mapper);
            $this->conn->executeNonQuery($queryUpt);
            $id = $entity->getId();
            $this->updateRelations($entity, $mapper);
        }
        return $id;
    }

    /**
     * Update the entity relations.
     * 
     * OneToOne o ManyToMany.
     * 
     * @param type $entity 
     */
    public function updateRelations($entity, $mapper) {
        foreach ($mapper->getRelations() as $relation) {
            if ($relation->getCardinality() == Relation::$manyToMany) {
                // delete previous relations
                $queryDeletePrevious = $this->buildDeleteRelationQuery($relation, $entity);
                $this->conn->executeNonQuery($queryDeletePrevious);

                // insert new relations
                $queryRel = $this->buildRelationQuery($entity);
                foreach (explode(";", $queryRel) as $q) {
                    if (strlen($q) > 5)
                        $this->conn->executeInsert($q);
                }
            }
            if ($relation->getCardinality() == Relation::$oneToMany) {
                $relMapper = MapperBuilder::buildFromName($this->mapping, $relation->getEntity());
                $m = "get" . $relation->getName();
                $setid = "set" . $relMapper->getNameForColumn($relation->getForeignColumn());

                // save actual relations
                foreach ($entity->$m() as $relEntity) {
                    $relEntity->$setid($entity->getId());
                    $this->save($relEntity);
                }

                //  delete old relations.
                // TODO: delete old relations
            }
        }
    }

    /**
     * Return an array of all entitys.
     * @param object $entity
     * @return array array of entitys.
     */
    public function findAll($name, $ordenColumn = null, $ordenType = null) {
        $mapper = MapperBuilder::buildFromName($this->mapping, $name);

        $query = "SELECT * FROM `" . $mapper->getTable() . "` ";
        if (!is_null($ordenColumn)) {
            $query .= "ORDER BY $ordenColumn ";
            if (!is_null($ordenType)) {
                $query .= "$ordenType";
            } else {
                $query .= "ASC";
            }
        }
        $raw = $this->conn->executeQuery($query);
        if ($raw) {
            $collection = new Collection($mapper->getClass(), $raw, $mapper);
        }
        return $collection;
    }

    /**
     * Find an entity bu its id.
     * @param type $class
     * @param type $id
     * @return \flowcode\orm\support\class 
     */
    public function findById($name, $id) {
        $mapper = MapperBuilder::buildFromName($this->mapping, $name);

        $newEntity = NULL;

        $query = "SELECT * FROM `" . $mapper->getTable() . "` WHERE id='$id'";
        $result = $this->conn->executeQuery($query);

        if ($result) {
            $class = $mapper->getClass();
            $newEntity = $mapper->createObject($result[0]);

            /* relations */
            foreach ($mapper->getRelations() as $relation) {

                $relMapper = MapperBuilder::buildFromName($this->mapping, $relation->getEntity());
                $queryRel = QueryBuilder::buildSelectRelation($newEntity, $relation, $relMapper);
                $resRel = $this->conn->executeQuery($queryRel);

                $method = "set" . $relation->getName();
                if ($resRel) {
                    foreach ($resRel as $row) {
                        $array[] = $relMapper->createObject($row);
                    }
                    $newEntity->$method($array);
                }
            }
        }
        return $newEntity;
    }

    /**
     * Delete an entity and its relations.
     * @param type $entity
     * @return boolean 
     */
    public function delete($entity) {
        $mapper = MapperBuilder::buildFromClassName($this->mapping, get_class($entity));
        $deleteQuerys = QueryBuilder::buildDeleteQuery($entity, $mapper);

        foreach (explode(";", $deleteQuerys) as $q) {
            if (strlen($q) > 5)
                $this->conn->executeNonQuery($q);
        }
        return true;
    }

    /**
     * 
     * @param \flowcode\orm\Entity $entity
     * @param type $relationName
     * @return \flowcode\orm\class
     */
    public function findRelation($entity, $relationName) {
        $mapper = MapperBuilder::buildFromClassName($this->mapping, get_class($entity));
        $relation = $mapper->getRelation($relationName);
        $relationMapper = MapperBuilder::buildFromName($this->mapping, $relation->getEntity());

        $selectQuery = "SELECT tmain.* FROM `" . $relationMapper->getTable() . "` tmain ";
        $joinQuery = QueryBuilder::buildJoinRelationQuery($relation, "tmain", "j1");
        $whereQuery = "WHERE j1." . $relation->getLocalColumn() . " = '" . $entity->getId() . "'";

        $query = $selectQuery . $joinQuery . $whereQuery;
        $queryResult = $this->conn->executeQuery($query);
        if ($queryResult) {
            $collection = new Collection($relationMapper->getClass(), $queryResult, $relationMapper);
        }  else {
            $collection = new Collection($relationMapper->getClass(), array(), $relationMapper);
        }

        return $collection;
    }

    /**
     * Finds entitys wich apply the filter.
     * Example: "name = 'some name'".
     * @param type $name
     * @param type $filter
     * @param type $orderColumn
     * @param type $orderType
     * @return \flowcode\orm\class
     */
    public function findByWhereFilter($name, $filter, $orderColumn = null, $orderType = NULL) {
        $mapper = MapperBuilder::buildFromName($this->mapping, $name);

        $query = "SELECT * FROM `" . $mapper->getTable() . "` ";
        $query .= "WHERE 1 ";
        if (!is_null($filter)) {
            $query .= "AND $filter ";
        }

        if (!is_null($orderColumn)) {
            $query .= "ORDER BY `$orderColumn` ";
            if (!is_null($orderType)) {
                $query .= "$orderType";
            } else {
                $query .= "ASC ";
            }
        }
        $result = $this->conn->executeQuery($query);

        if ($result) {
            $collection = new Collection($mapper->getClass(), $result, $mapper);
        } else {
            $collection = new Collection($mapper->getClass(), array(), $mapper);
        }

        return $collection;
    }

    /**
     * Finds entitys by its generic filter defined in the configured mapping.
     * @param type $name
     * @param type $filter
     * @param type $page
     * @param type $orderColumn
     * @param type $orderType
     * @return Pager
     */
    public function findByGenericFilter($name, $filter = null, $page = 1, $orderColumn = null, $orderType = null) {
        $mapper = MapperBuilder::buildFromName($this->mapping, $name);

        $selectQuery = "";
        $whereQuery = "";
        $orderQuery = "";

        $selectQuery .= "SELECT * FROM `" . $mapper->getTable() . "` ";
        $filterList = array();
        if (!is_null($filter)) {
            $filterList = explode(" ", $filter);
        }

        if (!is_null($filter)) {
            $whereQuery .= " WHERE 1=2 ";
            foreach ($filterList as $searchedWord) {
                foreach ($mapper->getFilter("generic")->getColumns() as $filteredColumn) {
                    $whereQuery .= " OR $filteredColumn LIKE '%" . $searchedWord . "%'";
                }
            }
        } else {
            $whereQuery .= " WHERE 1 ";
        }

        if (!is_null($orderColumn)) {
            $orderQuery .= "ORDER BY $orderColumn ";
            if (!is_null($orderType)) {
                $orderQuery .= "$orderType";
            } else {
                $orderQuery .= "ASC";
            }
        }

        $from = ($page - 1) * $mapper->getFilter("generic")->getItemsPerPage();
        $pageQuery = " LIMIT $from , " . $mapper->getFilter("generic")->getItemsPerPage();

        $query = $selectQuery . $whereQuery . $orderQuery . $pageQuery;
        $result = $this->conn->executeQuery($query);

        if ($result) {
            $collection = new Collection($mapper->getClass(), $result, $mapper);
        }

        $selectCountQuery = "SELECT count(*) as total FROM `" . $mapper->getTable() . "` ";
        $query = $selectCountQuery . $whereQuery;
        $result = $this->conn->executeQuery($query);
        $itemCount = $result[0]["total"];
        $pager = new Pager($collection, $itemCount, $mapper->getFilter("generic")->getItemsPerPage(), $page);

        return $pager;
    }

    public function getDataSource() {
        return $this->conn;
    }

    public function setDataSource($conn) {
        $this->conn = $conn;
    }

    public function getMappingFilePath() {
        return $this->mappingFilePath;
    }

    public function setMappingFilePath($mappingFilePath) {
        $this->mappingFilePath = $mappingFilePath;
    }

    public function getMapping() {
        return $this->mapping;
    }

    public function setMapping($mapping) {
        $this->mapping = $mapping;
    }

    public function populateEntity($entity, $values, $mapper = null, $relationColumn = null) {
        if (is_null($mapper)) {
            $mapper = MapperBuilder::buildFromClassName($this->mapping, get_class($entity));
        }
        foreach ($values as $key => $value) {
            if ($mapper->getNameForColumn($key) != NULL) {
                $method = "set" . $mapper->getNameForColumn($key);
                $entity->$method($value);
            }
        }
    }

}

?>
