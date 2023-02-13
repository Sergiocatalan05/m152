<?php
require_once("config.php");

function db()
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = DB_TYPE . ':host=' . HOST . ';dbname=' . DB_NAME . ';charset=utf8';

        //Creation de l'objet PDO
        $pdo = new PDO($dsn, USER_NAME, DB_PASSWORD);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    return $pdo;
}

function dbRun($sql, $param = null)
{
    $statement = db()->prepare($sql);
    $result = $statement->execute($param);
    return $statement;

}
