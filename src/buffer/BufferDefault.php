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
    public function add ($value): void {
      $this->buffer[] = $value;
    }
  
  
  
    /**
     * Returns first Param item in buffer and null if buffer is empty
     *
     * @return Param|null
     */
    public function shift (): Param|null {
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
  
  
  
    function load ($values): void {
      $this->buffer = $values;
    }



    function rewind (): void {}



    function set (string|int $key, Param $value): void {
        foreach ($this->buffer as $k => $param) {
            if ($param->name_raw() === $key) {
                $this->buffer[$k] = $value;
            }
        }
    }



    function exists (string|int $key): bool {
        return isset($this->buffer[$key]);
    }
  }