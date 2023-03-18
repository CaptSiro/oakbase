<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/Config.php";
  
  class BasicConfig implements Config {
    private string $host, $port, $database_name, $user, $password, $charset;
    
    public function __construct(string $host, string $database_name, string $user, string $password, string $port = "3306", string $charset = "UTF8") {
      $this->host = $host;
      $this->port = $port;
      $this->database_name = $database_name;
      $this->user = $user;
      $this->password = $password;
      $this->charset = $charset;
    }
  
    function host(): string {
      return $this->host;
    }
  
    function port(): string {
      return $this->port;
    }
  
    function database_name(): string {
      return $this->database_name;
    }
  
    function user(): string {
      return $this->user;
    }
  
    function password(): string {
      return $this->password;
    }
  
    function charset(): string {
      return $this->charset;
    }
  }