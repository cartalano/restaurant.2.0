<?php

const DBHOST = "db";
const DBUSER = "nico";
const DBPASS = "pass";
const DBNAME = "comments";

$dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;

try {
    $db = new PDO($dsn, DBUSER, DBPASS);

    echo "connecté";
}catch(PDOException $exception){
    echo "une erreur est survenue : " . $exception->getMessage();
    die;
}