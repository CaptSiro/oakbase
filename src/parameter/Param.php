<?php
  
  namespace OakBase;

  interface Param {
    /**
     * Return
     *
     * @return string
     */
    function __toString (): string;
    
    
    
    
    function to_string (): string;
  
  
    
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
    
    
    
    /**
     * Return string that was returned by `__toString()` method or null to use indexed based binding (`"?"` was returned)
     */
    function name (): ?string;
  }