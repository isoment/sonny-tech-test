<?php

declare(strict_types=1);

class Database
{
    private PDO $pdo;

    /**
     *  When the database object is created we want to instantiate a new
     *  PDO object passing in the proper credentials. If we cannot create
     *  a connection then throw an error.
     */
    public function __construct()
    {
        // Since we are using a new PHP version we probably don't need to
        // emulate prepares anymore. Appears to only be needed for old versions
        // for performance reasons.
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_STR_PARAM => PDO::FETCH_ASSOC
        ];

        $dsn = 'mysql:dbname=test_db;host=mysql';

        try {
            $this->pdo = new PDO($dsn, 'root', 'secret', $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *  When calling any method on this object that doesn't exist we
     *  want to proxy it to the PDO instance we create in the constructor.
     */
    public function __call(string $name, array $arguments) : mixed
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}

class Customer
{
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Let's create a customers table
    public function createCustomersTable() : bool
    {
        $createQuery = "
            CREATE TABLE customers (
                id INT NOT NULL AUTO_INCREMENT,
                first_name VARCHAR(255),
                last_name VARCHAR(255),
                PRIMARY KEY (id)
            );
        ";

        try {
            $stmt = $this->db->query('DROP TABLE IF EXISTS customers;');
            $stmt = $this->db->query($createQuery);
            return $stmt ? true : false;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // Let's populate the customers table with some dummy data
    public function populateCustomersTable() : bool
    {
        $query = "
            INSERT INTO 
                customers(first_name, last_name)
            VALUES
                ('Frank', 'Smith'),
                ('John', 'Doe'),
                ('Bill', 'Murphy'),
                ('Sally', 'Smith'),
                ('Adam', 'West')
        ";

        try {
            $stmt = $this->db->query($query);
            return $stmt ? true : false;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // Query the database to get a collection of all customers with a given last name. Use
    // a prepared statement to prevent SQL injections.
    public function findByLastName(string $lastName) : ?array
    {
        if (!$lastName) return null;

        $statement = $this->db->prepare("
            SELECT *
            FROM customers
            WHERE last_name = ?
        ");

        try {
            $statement->execute([$lastName]);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Throwable $e) {
            echo $e->getMessage();
            return null;
        }
    }
}


$customer = new Customer();
// Create a customers table
$customer->createCustomersTable();
// Fill it with some dummy data
$customer->populateCustomersTable();
// Get all customers with the given last name as an associative array
$byLastName = $customer->findByLastName($_GET['last_name']);

var_dump($byLastName);