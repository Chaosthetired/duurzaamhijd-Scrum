<?php

class PdoDatabase
{
        //Setup variables needed for the connection(hostname, username, password, database name)
        private $host;
        private $user;
        private $pass;
        private $dbname;

        //Database handler to handle queries etc
        public $dbh;

        //Errors are stored in $error
        public $error;

        //This variable will be used to set the queries from other .PHP files
        private $queryString;

    public function __construct($host, $user, $pass, $dbname)
    {

        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;

        //Database Server Name($DSN)
        $dsn = "pgsql:host=" . $host . ";dbname=" . $dbname . ";";

        //Options for the PDO statement

        $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );



        try {
            //Try to make a new PDO in the databasehandler ($dbh / dbh)
            //Fill in the $dsn, $user, $pass and the $options
            $this->dbh = new PDO($dsn, $user, $pass, $options);
            //$this->dbh->exec("set names utf8");
        } catch (PDOException $e) {
            //Error handler
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }



    public function query($query)
    {
        //Query setup
        //The $query will be filled in to $this->queryString, the databasehandler(dbh) will prepare this query
        $this->queryString = $this->dbh->prepare($query);
    }
        //Bind: This will bind the Parameter(i.e. :artistID), $param, with the value($value).
        //$type is set to null, which will trigger the if statement, which will trigger the switch.
        //The switch checks if the $value is an integer, a boolean, a null value, or a string. This wel set $type to the
        //specific PDO::PARAM_***
    public function bind($param, $value, $type = null)
    {

        if ($this->queryString === null) {
            // You can throw an exception or error here to catch when the query string is not set
            throw new Exception('Query string not initialized');
        }

        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->queryString->bindValue($param, $value, $type);
    }



    public function getFormattedQuery()
    {

        $query = $this->queryString->queryString;
        $bindings = $this->queryString->debugDumpParams();
        ob_start();
        $this->queryString->debugDumpParams();
        $bindings = ob_get_clean();
        return $query . " with bindings: " . $bindings;
    }



    public function execute($bool_debug = false)
    {

        if ($bool_debug) {
            echo $this->getFormattedQuery();
        }

        try {
            return $this->queryString->execute();
        } catch (exception $e) {
            error_log("FOUT BY QUERY: " . $e->getMessage());

            throw new Exception("<b>FOUT BY QUERY:</b> " . $e->getMessage());
        }
    }



    public function getRows()
    {

        //Get all results of the query
        //$this->execute();
        return $this->queryString->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getRow()
    {
        //Get a single result of the query
        //$this->execute();

        return $this->queryString->fetch(PDO::FETCH_ASSOC);
    }



    public function seekData($value)
    {
        // mysql_data_seek -> PDO
        // not sure if this is right

        return $this->queryString->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_ABS, $value);
    }



    public function rowCount()
    {
        //Count the rows of the query, how many there are, how many affected etc.

        return $this->queryString->rowCount();
    }



    public function lastInsertID()
    {
        //Get the last inserted ID of the query

        return $this->dbh->lastInsertId();
    }



    public function beginTransaction()
    {
        //Start of the transaction

        $this->dbh->beginTransaction();
    }



    public function endTransaction()
    {
        //End the transaction(commit it)

        $this->dbh->commit();
    }



    public function cancelTransaction()
    {
        //Cancel the transaction with a rollBack();

        $this->dbh->rollBack();
    }



    public function debugDumpParams()
    {
        //Get the query(echo) on the screen with the filled in parameters

        return $this->queryString->debugDumpParams();
    }



    public function gethost()
    {
        //Get the current host in the current connection which it is called upon

        return $this->host;
    }



    public function getuser()
    {
        //Get the current user of the DB in the current connection which it is called upon

        return $this->user;
    }



    public function getdb()
    {
        //Get the Database name in the current connection which it is alled upon

        return $this->dbname;
    }



    public function close()
    {
        //Sets the Database Handler to null which means our connection is closed.

        $this->dbh = null;
    }
}
