<?php
  
  namespace Database;
  use PDO;
  use stdClass;


  require_once __DIR__ . "/ParamBuffer.php";
  require_once __DIR__ . "/CreationException.php";
  require_once __DIR__ . "/SideEffect.php";
  
  
  
  class Database {
    private PDO $connection;
    
    
    
    private static Config $config;
    public static function configure (Config $config) {
      self::$config = $config;
    }
  
  
  
    private static Database $instance;
    public static function get(): Database {
      if (!isset($instance)) {
        self::$instance = new Database();
      }
      
      return self::$instance;
    }
    
    
  
    /**
     * @throws CreationException
     */
    public function __construct() {
      if (!isset(self::$config)) {
        throw new CreationException("Must set config object before creating connection to database. Use Database::configure() with custom object that implements Config or use BasicConfig class.");
      }
      
      $connectionString = "mysql:host=". self::$config->host()
        .";port=". self::$config->port()
        .";dbname=". self::$config->database_name()
        .";charset=". self::$config->charset();
      $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // errors from MySQL will appear as PHP Exceptions
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false // SQL injection
      ];
      $this->connection = new PDO($connectionString, self::$config->user(), self::$config->password(), $opt);
    }
    
    
    
    public function last_inserted_ID() {
      return $this->connection->lastInsertId();
    }
  
  
    
    /**
     * Run a query that does not return any rows such as UPDATE, DELETE, INSERT or TRUNCATE.
     *
     * @param $sql
     * @return SideEffect
     */
    public function statement ($sql): SideEffect {
      $stmt = $this->connection->prepare($sql);
      
      $i = 1;
      while (!ParamBuffer::is_empty()) {
        $param = ParamBuffer::shift();
        $stmt->bindValue($i++, $param->value(), $param->type());
      }
      
      $stmt->execute();

      return new SideEffect(
        $this->last_inserted_ID(),
        $stmt->rowCount()
      );
    }
  
  
    
    /**
     * Fetch a single row.
     *
     * @param string $sql
     * @param string $class
     * @return mixed
     */
    public function fetch (string $sql, string $class = stdClass::class) {
      $stmt = $this->connection->prepare($sql);
  
      $i = 1;
      while (!ParamBuffer::is_empty()) {
        $param = ParamBuffer::shift();
        $stmt->bindValue($i++, $param->value(), $param->type());
      }
      
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
      
      return $stmt->fetch();
    }
  
  
    
    /**
     * Fetch multiple rows.
     *
     * @param $sql
     * @param string $class
     * @return array|false
     */
    public function fetch_all ($sql, string $class = stdClass::class) {
      $stmt = $this->connection->prepare($sql);
  
      $i = 1;
      while (!ParamBuffer::is_empty()) {
        $param = ParamBuffer::shift();
        $stmt->bindValue($i++, $param->value(), $param->type());
      }
      
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
      
      return $stmt->fetchAll();
    }
  }