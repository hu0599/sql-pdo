<?php

class Database
{
    private function connect()
    {
        set_exception_handler(function ($e) {
            error_log("# " . $e->getMessage() . "\r\n", 3, __DIR__ . "/errors.log");
            exit('Please try again later! Reason:: adding new features to our website.'); // :)
        });

        $dsn = "mysql:host=localhost;dbname=db;charset=utf8mb4";
        $username = 'admin';
        $password = 'pass123';

        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,                  // turn off emulation mode
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // turn on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // make the default fetch an associative array
        ];

        return new PDO($dsn, "$username", "$password", $options);
    }
}