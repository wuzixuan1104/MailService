<?php
namespace Api\Structure;

Interface RequestInterface {
    public function requiredField();
    public function getViewParams();
    public function getView();
    public function getSubject();
    public function getMailSecret();
}
