<?php
namespace Api\Factory\ebs\acer\hotel;
use Api\Structure\MailInterface;
use Api\Template\TplParamsResponse;

class Apply {
    public function confirm($params = []) {
        return new Confirm($params);
    }
}

class Confirm extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() {
        return config('mail', 'ebs', 'acer', 'hotel', 'apply', 'confirm', 'view');
    }

    public function getSubject() {
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'apply', 'confirm', 'title');
    }

    public function getMailSecret() {
        return config('mailSecret', 'ebs', 'acer');
    }
}