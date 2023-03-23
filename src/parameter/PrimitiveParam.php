<?php
  
  namespace OakBase;

  require_once __DIR__ . "/Param.php";
  require_once __DIR__ . "/../buffer/ParamBuffer.php";
  
  require_once __DIR__ . "/ParamStringifier.php";
  require_once __DIR__ . "/ParamType.php";
  
  class PrimitiveParam implements Param {
    /**
     * @var mixed $value
     */
    private $value;
  
  
    
    /**
     * Basic implementation for primitive types such as string, number or NULL
     *
     * @param mixed $value
     */
    public function __construct ($value) {
      $this->value = $value;
    }
  
    
    
    function value () {
      return $this->value;
    }
  
    use ParamType, ParamStringifier;
  }