<?php
namespace Api\Template\edm\hotel\apply\confirm;

use Api\Template\Validator;
use Api\Structure\TemplateInterface;


class Member_v1 implements TemplateInterface {
    public $rqParams;

    public function __construct($params) {
        $params && $this->rqParams = Validator::checkFormat($this->requiredField(), $params);
    }

    public function requiredField() {
        return [
            'title'         => 'String|max:100',
            'hotelName'     => 'String|max:10',
            'leader'        => 'String|max:30',
            'place'         => 'String',
            'postNumber'    => 'String|max:50'
        ];
    }

    public function getViewParams() {
        return isset($this->rqParams['ValidatorError']) ? $this->rqParams : 
        [
            'title'         => $this->rqParams['title'],
            'hotelName'     => $this->rqParams['hotelName'],
            'leader'        => $this->rqParams['leader'],
            'place'         => $this->rqParams['place'],
            'postNumber'    => $this->rqParams['postNumber'],
        ]; 
    }
}