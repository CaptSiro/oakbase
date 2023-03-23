<?php
  
  namespace OakBase;
  
  trait BufferDefault {
    /**
     * @var Param[] $buffer
     */
    private array $buffer = [];
  
    
    
    /**
     * Adds a new object to the buffer that must implement Param interface
     *
     * @param Param $value
     * @return void
     */
    public function add ($value) {
      $this->buffer[] = $value;
    }
  
  
  
    /**
     * Returns first Param item in buffer and null if buffer is empty
     *
     * @return Param
     */
    public function shift (): Param {
      return array_shift($this->buffer);
    }
  
  
  
    public function is_empty (): bool {
      return empty($this->buffer);
    }
  
  
  
    function dump (): array {
      $temp = $this->buffer;
      $this->buffer = [];
      return $temp;
    }
  
  
  
    function load ($values) {
      $this->buffer = $values;
    }
  }