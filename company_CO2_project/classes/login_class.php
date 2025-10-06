<?php 


class login
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

public function selectAllUsers()
    {
        $query = "SELECT * FROM users";
        $this->pdo->query($query);
        $this->pdo->execute();
        return $this->pdo->getRows();
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE Username = :username";
        $this->pdo->query($query);
        $this->pdo->bind(':username', $username);
        $this->pdo->execute();
        return $this->pdo->getRow();
    }

    public function addAdmin($username, $passwordCode, $password, $role){
        $query = "INSERT INTO users (Username, passwordCode, password, Role) 
        VALUES (:username, :passwordCode, :password, :Role)";
        $this->pdo->query($query);
        $this->pdo->bind(':username', $username);
        $this->pdo->bind(':passwordCode', $passwordCode);
        $this->pdo->bind(':password', $password);
        $this->pdo->bind(':Role', $role);
        $this->pdo->execute();
        return $this->pdo->lastInsertId();
    }
}