<?php

namespace flowcode\orm;

use flowcode\orm\builder\MapperBuilder;
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

    /**
     * Return an EntityManager instance.
     * @return EntityManager
     */
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
        $id = "";
        if (is_null($entity->getId())) {
            // insert entity
            $queryIns = $this->buildInsertQuery($entity);
            $id = $this->conn->insertSQL($queryIns);
            $entity->setId($id);

            // relations
            $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));
            foreach ($mapper->getRelations() as $relation) {
                $queryRel = $this->buildRelationQuery($entity, $relation);
                foreach (explode(";", $queryRel) as $q) {
                    if (strlen($q) > 5)
                        $this->conn->executeInsert($q);
                }
            }
        } else {
            $queryUpt = $this->buildUpdateQuery($entity);
            $this->conn->executeNonQuery($queryUpt);
            $id = $entity->getId();
            $this->updateRelations($entity);
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
    public function updateRelations($entity) {
        $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));
        foreach ($mapper->getRelations() as $relation) {
            if ($relation->getCardinality() == Relation::$manyToMany) {

                // delete previous relations
                $queryDeletePrevious = $this->buildDeleteRelationQuery($relation, $entity);
                $this->conn->executeNonQuery($queryDeletePrevious);

                // insert new relations
                $queryRel = $this->buildRelationQuery($entity, $relation);

                foreach (explode(";", $queryRel) as $q) {
                    if (strlen($q) > 5) {
                        $this->conn->executeInsert($q);
                    }
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
     * Build a delete query for an entity.
     * @param type $entity
     * @return string 
     */
    public function buildDeleteQuery($entity) {
        $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));
        $query = "";
        foreach ($mapper->getRelations() as $relation) {
            $query .= $this->buildDeleteRelationQuery($relation, $entity);
        }

        $query .= "DELETE FROM " . $mapper->getTable() . " ";
        $query .= "WHERE id = '" . $entity->getId() . "';";

        return $query;
    }

    /**
     * Build a delete query for an entity an its relation.
     * @param type $relation
     * @param type $entity
     * @return string 
     */
    public function buildDeleteRelationQuery($relation, $entity) {
        $query = "DELETE FROM " . $relation->getTable() . " ";
        $query .= "WHERE " . $relation->getLocalColumn() . " = '" . $entity->getId() . "';";
        return $query;
    }

    /**
     * Return the entity insert query.
     * @param type $entity
     * @return string 
     */
    public function buildInsertQuery($entity) {

        $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));
        $fields = "";
        $values = "";
        foreach ($mapper->getPropertys() as $property) {
            if ($property->getColumn() != "id") {
                $method = "get" . $property->getName();
                $entity->$method();
                $fields .= "`" . $property->getColumn() . "`, ";
                $values .= "'" . $entity->$method() . "', ";
            }
        }

        $fields = substr_replace($fields, "", -2);
        $values = substr_replace($values, "", -2);

        $query = "INSERT INTO `" . $mapper->getTable() . "` (" . $fields . ") VALUES (" . $values . ");";

        return $query;
    }

    public function buildRelationQuery($entity, $relation) {
        $relQuery = "";
        $getid = "getId";
        if ($relation->getCardinality() == Relation::$manyToMany) {
            $m = "get" . $relation->getName();
            foreach ($entity->$m() as $rel) {
                $relQuery .= "INSERT INTO " . $relation->getTable() . " (" . $relation->getLocalColumn() . ", " . $relation->getForeignColumn() . ") ";
                $relQuery .= "VALUES ('" . $entity->$getid() . "', '" . $rel->$getid() . "');";
            }
        }
        if ($relation->getCardinality() == Relation::$oneToMany) {
            $relMapper = MapperBuilder::buildFromName($this->mapping, $relation->getEntity());
            $m = "get" . $relation->getName();
            foreach ($entity->$m() as $rel) {
                $setid = "set" . $relMapper->getNameForColumn($relation->getForeignColumn());
                $rel->$setid($entity->$getid());
                $relQuery .= $this->buildInsertQuery($rel);
            }
        }

        return $relQuery;
    }

    public function buildJoinRelationQuery(Relation $relation, $mainSynonym, $joinSynonym) {
        $query = "";
        if ($relation->getCardinality() == Relation::$manyToMany) {
            $query .= "INNER JOIN " . $relation->getTable() . " $joinSynonym ";
            $query .= "ON $joinSynonym." . $relation->getForeignColumn() . " = " . $mainSynonym . ".id ";
        }

        return $query;
    }

    /**
     * Return the entity insert query.
     * @param type $entity
     * @return string 
     */
    public function buildUpdateQuery($entity) {
        $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));

        $fields = "";
        foreach ($mapper->getPropertys() as $property) {
            if ($property->getColumn() != "id") {
                $method = "get" . $property->getName();
                $entity->$method();
                $fields .= "`" . $property->getColumn() . "`='" . $entity->$method() . "', ";
            }
        }
        $fields = substr_replace($fields, "", -2);
        $query = "UPDATE `" . $mapper->getTable() . "` SET " . $fields . " WHERE id='" . $entity->getId() . "'";

        return $query;
    }

    /**
     * Get the query for select the related entitys.
     * @param type $entity
     * @param type $relation Name of the relation.
     */
    public function buildSelectRelation($entity, $mapper, $relation, $mapperRelation) {
        $query = "";

        $fields = "";
        foreach ($mapperRelation->getPropertys() as $property) {
            $fields .= "c." . $property->getColumn() . ", ";
        }
        $fields = substr_replace($fields, "", -2);

        if ($relation->getCardinality() == Relation::$manyToMany) {
            $query = "select " . $fields . " from " . $mapperRelation->getTable() . " c ";
            $query .= "inner join " . $relation->getTable() . " nc on nc." . $relation->getForeignColumn() . " = c.id ";
            $query .= "where nc." . $relation->getLocalColumn() . " = " . $entity->getId();
        }
        if ($relation->getCardinality() == Relation::$oneToMany) {
            $query = "select " . $fields . " from " . $mapperRelation->getTable() . " c ";
            $query .= "where c." . $relation->getForeignColumn() . " = " . $entity->getId();
        }
        return $query;
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
        $result = $this->conn->executeQuery($query);

        $array = array();
        if ($result) {
            $class = $mapper->getClass();
            foreach ($result as $row) {
                $newEntity = new $class();
                $this->populateEntity($newEntity, $row, $mapper);
                $array[] = $newEntity;
            }
        }

        return $array;
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
            $newEntity = new $class();
            $this->populateEntity($newEntity, $result[0], $mapper);

            // populate relations
            foreach ($mapper->getRelations() as $relation) {

                $relMapper = MapperBuilder::buildFromName($this->mapping, $relation->getEntity());
                $queryRel = $this->buildSelectRelation($newEntity, $mapper, $relation, $relMapper);
                $resRel = $this->conn->executeQuery($queryRel);

                $classRel = $relMapper->getClass();
                $method = "set" . $relation->getName();
                if ($resRel) {
                    foreach ($resRel as $row) {
                        $newEntityRel = new $classRel();
                        $this->populateEntity($newEntityRel, $row, $relMapper, $relation->getForeignColumn());
                        $array[] = $newEntityRel;
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
        $deleteQuerys = $this->buildDeleteQuery($entity);
        foreach (explode(";", $deleteQuerys) as $q) {
            if (strlen($q) > 5)
                $this->conn->executeNonQuery($q);
        }
        return true;
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
            $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));
        }
        foreach ($values as $key => $value) {
            if ($mapper->getNameForColumn($key) != NULL) {
                $method = "set" . $mapper->getNameForColumn($key);
                $entity->$method($value);
            }
        }
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

        $from = ($page-1)*$mapper->getFilter("generic")->getItemsPerPage();
        $pageQuery = " LIMIT $from , " . $mapper->getFilter("generic")->getItemsPerPage();

        $query = $selectQuery . $whereQuery . $orderQuery . $pageQuery;
        $result = $this->conn->executeQuery($query);

        $array = array();
        if ($result) {
            $class = $mapper->getClass();
            foreach ($result as $row) {
                $newEntity = new $class();
                $this->populateEntity($newEntity, $row, $mapper);
                $array[] = $newEntity;
            }
        }

        $selectCountQuery = "SELECT count(*) as total FROM `" . $mapper->getTable() . "` ";
        $query = $selectCountQuery . $whereQuery;
        $result = $this->conn->executeQuery($query);
        $itemCount = $result[0]["total"];
        $pager = new Pager($array, $itemCount, $mapper->getFilter("generic")->getItemsPerPage(), $page);

        return $pager;
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

        $array = array();
        if ($result) {
            $class = $mapper->getClass();
            foreach ($result as $row) {
                $newEntity = new $class();
                $this->populateEntity($newEntity, $row, $mapper);
                $array[] = $newEntity;
            }
        }

        return $array;
    }

    /**
     * Finds entitys by the passed filter.
     * @param type $name
     * @param type $filter
     * @param type $orderColumn
     * @param type $orderType
     * @param type $page
     * @return Pager
     */
    public function findByWhereFilterPaged($name, $filter, $orderColumn = null, $orderType = NULL, $page = 1) {
        $mapper = MapperBuilder::buildFromName($this->mapping, $name);

        $selectQuery = "SELECT * FROM `" . $mapper->getTable() . "` ";
        $whereQuery = "WHERE 1 ";
        if (!is_null($filter)) {
            $whereQuery .= "AND $filter ";
        }

        $orderQuery = "";
        if (!is_null($orderColumn)) {
            $orderQuery .= "ORDER BY $orderColumn ";
            if (!is_null($orderType)) {
                $orderQuery .= "$orderType";
            } else {
                $orderQuery .= "ASC";
            }
        }
        $from = ($page-1)*$mapper->getFilter("generic")->getItemsPerPage();
        $pageQuery = " LIMIT $from , " . $mapper->getFilter("generic")->getItemsPerPage();
        $query = $selectQuery . $whereQuery . $orderQuery . $pageQuery;
        $queryResult = $this->conn->executeQuery($query);

        $array = array();
        if ($queryResult) {
            $class = $mapper->getClass();
            foreach ($queryResult as $row) {
                $newEntity = new $class();
                $this->populateEntity($newEntity, $row, $mapper);
                $array[] = $newEntity;
            }
        }

        $selectCountQuery = "SELECT count(*) as total FROM `" . $mapper->getTable() . "` ";
        $query = $selectCountQuery . $whereQuery;
        $result = $this->conn->executeQuery($query);
        $itemCount = $result[0]["total"];
        $pager = new Pager($array, $itemCount, $mapper->getFilter("generic")->getItemsPerPage(), $page);

        return $pager;
    }

    public function findByRelation($entityName, $relationName, $relationWhere, $page) {
        $mapper = MapperBuilder::buildFromName($this->mapping, $entityName);

        $selectQuery = "SELECT tmain.* FROM `" . $mapper->getTable() . "` tmain ";

        $relation = $mapper->getRelation($relationName);
        $joinQuery = $this->buildJoinRelationQuery($relation, "tmain", "j1");

        $whereQuery = "WHERE 1 ";
        if (!is_null($relationWhere)) {
            $whereQuery .= "AND $relationWhere ";
        }

        $pageQuery = " LIMIT $page , " . $mapper->getFilter("generic")->getItemsPerPage();

        $query = $selectQuery . $joinQuery . $whereQuery . $pageQuery;
        $queryResult = $this->conn->executeQuery($query);
        $array = array();
        if ($queryResult) {
            $class = $mapper->getClass();
            foreach ($queryResult as $row) {
                $newEntity = new $class();
                $this->populateEntity($newEntity, $row, $mapper);
                $array[] = $newEntity;
            }
        }

        $selectCountQuery = "SELECT tmain.*, count(*) as total FROM `" . $mapper->getTable() . "` tmain ";
        $query = $selectCountQuery . $joinQuery . $whereQuery;
        $result = $this->conn->executeQuery($query);
        $itemCount = $result[0]["total"];
        $pager = new Pager($array, $itemCount, $mapper->getFilter("generic")->getItemsPerPage());

        return $pager;
    }

    public function findRelation(Entity $entity, $relationName) {
        $mapper = MapperBuilder::buildFromMapping($this->mapping, get_class($entity));
        $relation = $mapper->getRelation($relationName);
        $relationMapper = MapperBuilder::buildFromName($this->mapping, $relation->getEntity());

        $selectQuery = "SELECT tmain.* FROM `" . $relationMapper->getTable() . "` tmain ";

        $joinQuery = $this->buildJoinRelationQuery($relation, "tmain", "j1");

        $whereQuery = "WHERE j1." . $relation->getLocalColumn() . " = '" . $entity->getId() . "'";

        $query = $selectQuery . $joinQuery . $whereQuery;
        $queryResult = $this->conn->executeQuery($query);
        $array = array();
        if ($queryResult) {
            $class = $relationMapper->getClass();
            foreach ($queryResult as $row) {
                $newEntity = new $class();
                $this->populateEntity($newEntity, $row, $relationMapper);
                $array[] = $newEntity;
            }
        }

        return $array;
    }

}

?>
