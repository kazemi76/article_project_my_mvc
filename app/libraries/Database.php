<?php

class Database
{

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; //data base handler
    private $stmt; //dastorat Amade
    private $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();

            echo $this->error;
        }
    }

    public function query($sql)
    {

        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($param, $value)
    {

        $this->stmt->bindParam($param, $value);
    }

    public function execute()
    {

        return $this->stmt->execute();
    }

    public function featchAll()
    {

        $this->execute();

        return $this->stmt->fetchAll();
    }

    public function featch()
    {

        $this->execute();

        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
