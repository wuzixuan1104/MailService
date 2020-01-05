<?php
namespace Api\Mail\Factory;

use Api\Validator;
use Api\Mail\Struct\ValidatorInterface;
use Api\Table;

class Template extends Factory implements ValidatorInterface {
  const TABLE = 'Template';

  static $tplParams = null; //樣板格式
  private $rqParams  = []; //request 

  public function __construct($id) {
    parent::__construct($id, self::TABLE);
  }

  public function getRQField() {
    if (self::$tplParams !== null)
      return self::$tplParams;

    if (!$this->params)
      return self::$tplParams = [];

    if (!self::$tplParams = json_decode($this->params, true)) {
      $this->error = '[Fail] ID: ' . $this->id . ' 的樣本參數格式不正確!';
      return false;
    }
    return self::$tplParams;
  }

  public function getRQParams() {
    return $this->rqParams;
  }

  public function checkRQParams($rqParams) {
    if (!$this->getRQField())
      return false;

    return $this->rqParams = Validator::checkFormat($this->getRQField(), $rqParams);
  }
}