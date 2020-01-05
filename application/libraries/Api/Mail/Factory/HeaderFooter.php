<?php
namespace Api\Mail\Factory;

use Api\Validator;
use Api\Mail\Struct\ValidatorInterface;
use Api\Table;

class HeaderFooter extends Factory implements ValidatorInterface {
    const TABLE = 'HeaderFooter';

    static $field     = null;
    private $rqParams = [];

    public function __construct($id) {
        parent::__construct($id, self::TABLE);
    }

    public function html() {
        if (!$this->getRQParams())
            return '';


    }

    //設定填入HTMl參數
    public function setHTMLParams($params) {

    }

    public function getRQField() {
        if (self::$field !== null)
            return self::$field;

        if (!$this->params)
            return self::$field = [];

        if (!self::$field = json_decode($this->params, true)) {
            $this->error = '[Fail] ID: ' . $this->id . ' 的參數格式不正確!';
            return false;
        }
        return self::$field;
    }

    public function getRQParams() {
        return $this->rqParams;
    }

    public function checkRQParams($rqParams) {
        if (!$this->getRQField())
            return $this;

        $this->rqParams = Validator::checkFormat($this->getRQField(), $rqParams);
        return $this;
    }
}