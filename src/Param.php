<?php
  
  namespace Database;
  use PDO;

  interface Param {
    /**
     * @return string Return "?"
     */
    function __toString (): string;
  
  
    
    /**
     * Return value to be used in database query
     *
     * @return mixed
     */
    function value ();
  
  
    
    /**
     * Return any of PDO::PARAM_* constants
     *
     * @return int
     */
    function type (): int;
  }
  
  
  
  require_once __DIR__ . "/ParamBuffer.php";
  
  trait ParamStringifier {
    /**
     * @throws ImplementationException
     */
    function __toString (): string {
      if (!$this instanceof Param) {
        throw new ImplementationException("You must implement the Param interface.");
      }
      
      ParamBuffer::add($this);
      return "?";
    }
  }
  
  
  
  const PARAM_TYPE_TABLE = [
    "boolean" => PDO::PARAM_BOOL,
    "integer" => PDO::PARAM_INT,
    "double" => PDO::PARAM_STR,
    "string" => PDO::PARAM_STR,
    "NULL" => PDO::PARAM_NULL,
  ];
  
  trait ParamType {
    function type(): int {
      $type = gettype($this->value);
      
      if (isset(PARAM_TYPE_TABLE[$type])) {
        return PDO::PARAM_STR;
      }
      
      return PARAM_TYPE_TABLE[$type];
    }
  }