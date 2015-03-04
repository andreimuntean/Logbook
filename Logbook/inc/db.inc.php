 <?php

   class DB {

      private static $db = NULL;
      public static $CONNECTION_STRING = "mysql:host=localhost;dbname=myLogbook;charset=utf8";
      public static $DB_USER = "root";
      public static $DB_PASS = "";

/**
 * Getting instance of the current database connection
 *
 * @return unique instance of PDO(PHP data object). If there is no existed PDO, creates new one.
 */

      public static function getInstance() {
          if (is_null(self::$db)) {
              self::$db = new PDO(self::$CONNECTION_STRING, self::$DB_USER, self::$DB_PASS);
          }
	        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return self::$db;
      }

  }

?>

