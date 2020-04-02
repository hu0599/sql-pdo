<?php

class Database
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = $this->connect();
        $this->table = 'test';
    }

    private function connect()
    {
        set_exception_handler(function ($e) {
            error_log("# " . $e->getMessage() . "\r\n", 3, __DIR__ . "/errors.log");
            exit('Please try again later! Reason:: adding new features to our website.'); // :)
        });

        $host = 'localhost';
        $dbName = 'db';
        $username = 'admin';
        $password = 'pass123'; // or empty
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,                  // turn off emulation mode
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // turn on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // make the default fetch an associative array
        ];

        return new PDO($dsn, "$username", "$password", $options);
    }

    public function insert()
    {
        $stmt = $this->pdo->prepare("INSERT INTO $this->table (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['john', 'john@example.com', sha1('secret')]); // [$_POST['name'], ...]
        $stmt = null;

        return $this;
    }

    public function update()
    {
        $stmt = $this->pdo->prepare("UPDATE $this->table SET name = ? WHERE id = ?");
        $stmt->execute(['Maxipaxi', 20]); // [$_POST['name'], $_SESSION['id']]
        $stmt = null;

        return $this;
    }
}