<?php
namespace Api\Mail\Factory;

use Api\Table;

class Factory {
  protected $error = '';

  public function __construct($id, $table) {
    if (!$this->exists($id, $table))
      return false;
  }

  public function exists($id, $table) {
    if (!$model = Table::create($table)->find($id))
      return $this->_errorHandler('[Fail] 找不到此信件！ID: ' . $id);

    $this->modelFormat($model);
    return $this;
  }

  protected function modelFormat($model) {
    foreach ($model as $attr => $val)
      $this->$attr = $val;
  }

  protected function _errorHandler($msg) {
    $this->error = $msg;
    return false;
  }
}