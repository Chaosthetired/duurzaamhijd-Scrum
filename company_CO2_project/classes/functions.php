<?php
class functions {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


public function addtype($type_name)
 { 
    $query = "INSERT INTO type_table (type_name) 
    VALUES (:type_name)"; $this->pdo->query($query); 
    $this->pdo->bind(':type_name', $type_name); 
    $this->pdo->execute(); 
    return $this->pdo->lastInsertId(); 
}

public function getTypeById($type_id)
{
    $query = "SELECT type_id, type_name
              FROM type_table
              WHERE type_id = :type_id";
    $this->pdo->query($query);
    $this->pdo->bind(':type_id', $type_id);
    $this->pdo->execute();

    // If your abstraction has single()/resultSet(), use single(); otherwise adjust to your fetch method.
    return $this->pdo->getRow(); 
}

public function getAllTypes()
{
    $query = "SELECT type_id, type_name
              FROM type_table
              ORDER BY type_id";
    $this->pdo->query($query);
    $this->pdo->execute();

    // If your abstraction has resultSet(), use it; otherwise adjust to your fetchAll method.
    return $this->pdo->getRows();
}

public function updateType($type_id, $type_name)
{
    $query = "UPDATE type_table
              SET type_name = :type_name
              WHERE type_id = :type_id";
    $this->pdo->query($query);
    $this->pdo->bind(':type_name', $type_name);
    $this->pdo->bind(':type_id', $type_id);
    $this->pdo->execute();
}
}