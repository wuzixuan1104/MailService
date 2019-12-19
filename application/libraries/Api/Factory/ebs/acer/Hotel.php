<?php
namespace Api\Factory\ebs\acer;
use Api\Structure\MailInterface;
use Api\Template\TplParamsResponse;

class Hotel {
    public function confirm($params = []) {
        return new HotelConfirm($params);
    }
}

class HotelConfirm extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() {
        return config('mail', 'ebs', 'acer', 'hotel', 'confirm', 'view');
    }
    
    public function getSubject() {
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'confirm', 'title');
    }

    public function getMailSecret() {
        return config('mailSecret', 'ebs', 'acer');
    }
}