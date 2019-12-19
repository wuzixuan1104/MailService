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
            'orderCode' => 'String|max:100',
            'status'    => 'String|max:10',
            'userInfo'  => [
                'name'  =>  'String|max:50',
                'phone:optional' => 'String',
            ],
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