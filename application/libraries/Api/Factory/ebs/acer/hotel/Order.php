<?php
namespace Api\Factory\ebs\acer\hotel;
use Api\Structure\MailInterface;
use Api\Template\TplParamsResponse;

class Order {
    public function confirm($params = []) {
        return new Confirm($params);
    }
    public function create($params = []) {
        return new Create($params);
    }
}

/* 以下取得 config 設定值 */

class Confirm extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() {
        return config('mail', 'ebs', 'acer', 'hotel', 'order', 'confirm', 'view');
    }

    public function getSubject() {
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'order', 'confirm', 'title');
    }

    public function getMailSecret() {
        return config('mailSecret', 'ebs', 'acer');
    }
}

class Create extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() {
        return config('mail', 'ebs', 'acer', 'hotel', 'order', 'create', 'view');
    }

    public function getSubject() {
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'order', 'create', 'title');
    }

    public function getMailSecret() {
        return config('mailSecret', 'ebs', 'acer');
    }
}