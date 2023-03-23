<?php
  
  namespace OakBase;
  
  interface Buffer {
    function add ($value);
    
    
    
    function shift ();
    
    
    
    function is_empty (): bool;
    
    
    
    function dump ();
    
    
    
    function load ($values);
  }