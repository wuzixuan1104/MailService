<?php
namespace Api\Factory\ebs\acer;
use Api\Factory\Validator;
use Api\Structure\RequestInterface;

class Hotel {
    //注意：function 名必須與 router 結尾相同
    public function confirm($params = []) {
        return new HotelConfirm($params);
    }
}

class HotelConfirm implements RequestInterface {
    public $rqParams;

    public function __construct($params) {
        $params && $this->rqParams = Validator::checkFormat($this->requiredField(), $params);
    }

    public function getSubject() {
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'confirm', 'title');
    }
    
    public function getView() {
        return config('mail', 'ebs', 'acer', 'hotel', 'confirm', 'view');
    }

    public function getMailSecret() {
        return config('mailSecret', 'ebs', 'acer');
    }

    public function requiredField() {
        return [
            'orderCode' => 'String',
            'status'    => 'String',
            'userInfo'  => 'Array',
        ];
    }

    public function getViewParams() {
        return isset($this->rqParams['ValidatorError']) ? $this->rqParams : 
        [
            'orderCode' => $this->rqParams['orderCode'],
            'status'    => $this->rqParams['status'],
            'name'      => $this->rqParams['userInfo']['name'],
        ]; 
    }
}