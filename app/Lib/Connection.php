<?php

namespace App\Lib;

use PDO;
use PDOException;

class Connection
{
    public $db;

    public function __construct()
    {
        $dnsStr = "mysql:host=%s;dbname=%s;charset=%s";
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');
        $db = getenv('DB_NAME');
        $host = getenv('DB_HOST');
        $charset = config('database.db_encoding');

        $dsn = sprintf($dnsStr, $host, $db, $charset);

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->db = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
}
