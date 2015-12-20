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
        /**
         * Check if the APP_ENV variable is set. If not found or it has a value of 'local'
         * then load variable values from app's .env file. Else load server server environment variables.
         */
        if (! getenv('APP_ENV') || getenv('APP_ENV')=="local") {
            $dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
            $dotenv->load();
        }

        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $driver = getenv('DB_DRIVER');

        return new PDO($driver.':host='.$host.';dbname='.$db, $username, $password);
    }
    catch (PDOException $e)
    {
        return $e->getMessage();
    }
  }
}