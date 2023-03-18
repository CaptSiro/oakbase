<?php
  
  namespace OakBase;
  use PDO;

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
    
      if (!isset(PARAM_TYPE_TABLE[$type])) {
        return PDO::PARAM_STR;
      }
    
      return PARAM_TYPE_TABLE[$type];
    }
  }