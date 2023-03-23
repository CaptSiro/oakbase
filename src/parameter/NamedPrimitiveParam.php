<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/Param.php";
  require_once __DIR__ . "/../buffer/ParamBuffer.php";
  
  require_once __DIR__ . "/ParamType.php";
  
  class NamedPrimitiveParam implements Param {
    private string $name;
    /**
     * @var mixed $value
     */
    private $value;
  
  
    
    /**
     * @param string $name Do not include `:`. It is prepended automatically
     * @param $value
     */
    public function __construct (string $name, $value) {
      $this->value = $value;
      $this->name = $name;
    }
    
    
  
    function __toString(): string {
      ParamBuffer::get()->add($this);
      return $this->name();
    }
  
    function to_string (): string {
      return "[". $this->name() ."]: '". $this->value() ."' (". $this->type() .")";
    }
  
    function value() {
      return $this->value;
    }
  
    function name(): ?string {
      return ":$this->name";
    }
    
    use ParamType;
  }