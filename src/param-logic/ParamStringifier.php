<?php
  
  namespace Database;

  require_once __DIR__ . "/ParamBuffer.php";

  trait ParamStringifier {
    /**
     * @throws ImplementationException
     * @return string
     */
    function __toString (): string {
      if (!$this instanceof Param) {
        throw new ImplementationException("You must implement the Param interface.");
      }
    
      ParamBuffer::add($this);
      return "?";
    }
  
    /**
     * @return string|null
     */
    function name (): ?string {
      return null;
    }
  }