<?php

namespace Wilson\Source;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Connection
{
  /**
   * This method creates and returns a connection to the database
   */
  public static function connect()
  {
    try
    {
      if (! getenv('APP_ENV') || getenv('APP_ENV')=="local") {
        // load config values from .env file if APP_ENV is not found.
        // APP_ENV is set on Heroku server
        $dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
        $dotenv->load();
      }

      $host = getenv('DB_HOST');
      $db = getenv('DB_NAME');
      $username = getenv('DB_USERNAME');
      $password = getenv('DB_PASSWORD');
      $driver = getenv('DB_DRIVER');

      return new PDO($driver.':host='.$host.';dbname='.$db.';charset=utf8', $username, $password);
    }
    catch (PDOException $e)
    {
      return $e->getMessage();
    }
  }
}