<?php
  
  namespace Database;

  require_once __DIR__ . "/Param.php";
  require_once __DIR__ . "/ParamBuffer.php";
  
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