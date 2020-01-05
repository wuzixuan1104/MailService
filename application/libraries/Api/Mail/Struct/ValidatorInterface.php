<?php

namespace Api\Mail\Struct;

Interface ValidatorInterface {
  public function getRQField();
  public function getRQParams();
  public function checkRQParams($rqParams);
}