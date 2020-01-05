<?php
namespace Api\Mail\Factory;

use Api\Validator;
use Api\Mail\Struct\ValidatorInterface;
use Api\Table;

class Template extends Factory implements ValidatorInterface {
  const TABLE = 'Template';

  public function __construct($id) {
    parent::__construct($id, self::TABLE);
  }

  public function getRQField() {
    return $this->params;
  }

  public function getRQParams() {

  }
}