<?php
namespace Api\Mail\Factory;

use Api\Table;

class Sender extends Factory {
  const TABLE = 'Sender';

  public function __construct($id) {
    parent::__construct($id, self::TABLE);
  }
}