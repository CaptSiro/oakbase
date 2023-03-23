<?php
  
  namespace OakBase;

  require_once __DIR__ . "/../buffer/ParamBuffer.php";

  trait ParamStringifier {
    /**
     * @throws ImplementationException
     * @return string
     */
    function __toString (): string {
      if (!$this instanceof Param) {
        throw new ImplementationException("You must implement the Param interface.");
      }
    
      ParamBuffer::get()->add($this);
      return "?";
    }
  
    /**
     * @return string|null
     */
    function name (): ?string {
      return null;
    }
  
    function to_string (): string {
      return "[". $this->name() ."]: '". $this->value() ."' (". $this->type() .")";
    }
  }