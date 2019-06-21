<?php

namespace IWD\JOBINTERVIEW\Entity;

class Survey {
  /**
  * Survey code
  * @var string
  **/
  private $code;

  /**
  * Survey name
  * @var string
  **/
  private $name;

  public function __construct(string $code, string $name)
  {
    $this->code = $code;
    $this->name = $name;
  }

  public function getCode() {
    return $this->code;
  }

  public function setCode(string $code) {
    $this->code = $code;
  }

  public function getName() {
    return $this->name;
  }

  public function setName(string $name) {
    $this->name = $name;
  }
}
