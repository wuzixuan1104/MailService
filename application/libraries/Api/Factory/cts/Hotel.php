<?php
namespace Api\Factory\cts;
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