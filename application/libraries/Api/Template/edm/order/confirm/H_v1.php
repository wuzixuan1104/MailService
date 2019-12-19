<?php
namespace Api\Template\edm\order\confirm;

use Api\Template\Validator;
use Api\Structure\TemplateInterface;


class H_v1 implements TemplateInterface {
    public $rqParams;

    public function __construct($params) {
        $params && $this->rqParams = Validator::checkFormat($this->requiredField(), $params);
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