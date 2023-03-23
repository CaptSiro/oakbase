<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/../parameter/Param.php";
  require_once __DIR__ . "/Buffer.php";
  require_once __DIR__ . "/BufferDefault.php";
  
  class ParamBuffer implements Buffer {
    use BufferDefault;
    
    
    
    private static self $instance;
    
    public static function get (): self {
      if (!isset(self::$instance)) {
        self::$instance = new self();
      }
      
      return self::$instance;
    }
  }