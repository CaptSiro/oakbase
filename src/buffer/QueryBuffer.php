<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/Buffer.php";
  require_once __DIR__ . "/BufferDefault.php";
  
  class QueryBuffer implements Buffer {
    use BufferDefault;



    private int $index = 0;



    public function shift(): Param|null {
        return $this->buffer[$this->index++];
    }



    public function is_empty(): bool {
        return !isset($this->buffer[$this->index]);
    }



    public function rewind(): void {
        $this->index = 0;
    }
  }