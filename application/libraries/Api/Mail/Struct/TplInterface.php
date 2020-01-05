<?php

namespace Api\Mail\Struct;

Interface TplInterface {
  public function html();
  public function getRQField();
  public function getRQParams();
  public function checkRQParams($rqParams);
}