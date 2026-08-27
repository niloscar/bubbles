<?php
/**
 * Database config
 */

function db(): PDO
{
  $host = getenv('DB_HOST');
  $port = getenv('DB_PORT');
  $dbname = getenv('DB_NAME');
  $username = getenv('DB_USER');
  $password = getenv('DB_PASSWORD');


  return new PDO(
    "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
    $username,
    $password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
}
