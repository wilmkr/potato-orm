<?php

namespace Wilson\Source;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Connection
{
  /**
   * Creates a connection to the database
   */
  public static function connect()
  {
    try
    {
      $dotenv = new Dotenv(__DIR__ . '/../');
      $dotenv->load();

      $host = getenv('DB_HOST');
      $db = getenv('DB_NAME');
      $username = getenv('DB_USERNAME');
      $password = getenv('DB_PASSWORD');

      return new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $username, $password);
    }
    catch (PDOException $e)
    {
      return $e->getMessage();
    }
  }
}