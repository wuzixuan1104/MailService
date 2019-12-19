<?php
namespace Api\Factory\cts\hotel;
use Api\Structure\MailInterface;
use Api\Template\TplParamsResponse;

class Order {
    public function confirm($params = []) {
        return new Confirm($params);
    }
}

class Confirm extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() {
        return config('mail', 'cts', 'hotel', 'confirm', 'view');
    }
    
    public function getSubject() {
        return config('mail', 'cts', 'hotel', 'subject') . ' - ' . 
               config('mail', 'cts', 'hotel', 'confirm', 'title');
    }

    public function getMailSecret() {
        return config('mailSecret', 'cts');
    }
}