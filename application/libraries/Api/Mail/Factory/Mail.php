<?php
namespace Api\Mail\Factory;

use Api\Table;

class Mail extends Factory {
  const TABLE = 'Mail';

  public function __construct($id) {
    parent::__construct($id, self::TABLE);
  }
}