<?php
namespace Api\Factory\ebs\acer;

class Hotel {
    protected $rqParams = [];

    public function __construct($params) {
        if (!($params && is_array($params)))
            return false;

        $this->rqParams = Validator::checkFormat(
            $this->requiredField(), 
            $params
        );
    }

    public function render() {
        return $body;
    }
}

class HotelConfirm {
    const VIEW = 'edm/order/confirm/H_v1';

    public function requiredField() {
        return [
            'OrderCode' => 'String',
            'Status'    => 'String',
            'UserInfo'  => 'Array',
        ];
    }

    public function getRQParams() {
        return isset($this->rqParams['ValidatorError']) ? $this->rqParams : 
        Validator::optionFormat(
        [
            'OrderCode' => $this->rqParams['OrderCode'],
            'Status'    => $this->rqParams['Status'],
            'name'      => $this->rqParams['UserInfo']['name'],
        ]); 
    }
}