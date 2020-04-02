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

    public function delete()
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->execute([25]); // [$_SESSION['id']
        $stmt = null;

        return $this;
    }

    public function updateColumn()
    {
        $stmt = $this->pdo->prepare("UPDATE $this->table SET name = ? WHERE id = ?");
        $stmt->execute(['Hans', 23]); // [$_POST['name'], $_SESSION['id']]
        $stmt->rowCount();
        $stmt = null;

        return $this;
    }

    public function lastInsertId()
    {
        $stmt = $this->pdo->prepare("INSERT INTO $this->table (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['ro', 'ro@gmail.com', 'password123']); // [$_POST['name'], $_POST['email'], $_POST['password']]
        $this->pdo->lastInsertId(); // echo
        $stmt = null;

        return $this;
    }

    public function fetchAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id <= ?");
        $stmt->execute([50]); // id
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$arr) return false;
        var_export($arr);
        $stmt = null;

        return $this;
    }

    public function selectOneColumn()
    {
        $stmt = $this->pdo->prepare("SELECT name FROM $this->table WHERE id > ?");
        $stmt->execute([12]); // id
        $arr = $stmt->fetchAll(PDO::FETCH_CLASS);
        if (!$arr) return false;
        var_export($arr);
        $stmt = null;

        return $this;
    }

    public function fetchOneRow()
    {
        $stmt = $this->pdo->prepare("SELECT id, name, email FROM $this->table WHERE id = ?");
        $stmt->execute([50]); // id
        $arr = $stmt->fetch();
        if (!$arr) return false;
        var_export($arr);
        // or only
        var_export($arr['email']);
        $stmt = null;

        return $this;
    }

    public function fetchKeyValuePair()
    {
        $stmt = $this->pdo->prepare("SELECT name, email FROM $this->table WHERE id < ?"); // could be age or ..
        $stmt->execute([24]); // age (add new column to table test)
        $arr = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        if (!$arr) return false;
        var_export($arr);
        $stmt = null;

        return $this;
    }

    public function search()
    {
        $search = 'ro'; // "%{$_POST['search']}%";
        $stmt = $this->pdo->prepare("SELECT id, name, email FROM $this->table WHERE name LIKE ?");
        $stmt->execute([$search]);
        $arr = $stmt->fetchAll();
        if (!$arr) return false;
        var_export($arr);
        $stmt = null;

        return $this;
    }

    public function whereInArray()
    {
        $inArray = [23, 24, 26]; // check your db if IDs exist
        $clause = implode(',', array_fill(0, count($inArray), '?'));
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id IN ($clause)");
        $stmt->execute($inArray);
        $resArr = $stmt->fetchAll();
        if (!$resArr) return false;
        var_export($resArr);
        $stmt = null;

        return $this;
    }
}