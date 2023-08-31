<?php
  
  namespace OakBase;
  
  interface Buffer {
    function add ($value);



    function set (string|int $key, Param $value): void;



    function exists (string|int $key): bool;
    
    
    
    function shift (): Param|null;



    function rewind (): void;
    
    
    
    function is_empty (): bool;
    
    
    
    function dump ();
    
    
    
    function load ($values);
  }