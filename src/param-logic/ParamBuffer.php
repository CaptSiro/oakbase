<?php
  
  namespace Database;
  
  require_once __DIR__ . "/Param.php";
  
  class ParamBuffer {
    /**
     * @var Param[] $buffer
     */
    private static array $buffer = [];
  
  
    
    /**
     * Adds a new object to the buffer that must implement Param interface
     *
     * @param Param $param
     * @return void
     */
    public static function add (Param $param) {
      self::$buffer[] = $param;
    }
  
  
    
    /**
     * Returns first Param item in buffer and null if buffer is empty
     *
     * @return Param
     */
    public static function shift (): Param {
      return array_shift(self::$buffer);
    }
  
  
    
    public static function is_empty (): bool {
      return empty(self::$buffer);
    }
  }