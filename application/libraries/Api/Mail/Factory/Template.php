<?php
namespace Api\Mail\Factory;

use Api\Validator;
use Api\Mail\Struct\TplInterface;
use Api\Table;

class Template extends Factory implements TplInterface {
    const TABLE = 'Template';

    static $tplParams = null; //樣板格式
    private $rqParams  = []; //request 

    public function __construct($id) {
        parent::__construct($id, self::TABLE);
    }

    public function html() {
        if ($this->id == 0 || !$this->content)
            return '';
        if (!$this->getRQParams())
            return $this->content;

        return loadView($this->content, $this->getRQParams());
    }

    public function getRQField() {
        if (self::$tplParams !== null)
            return self::$tplParams;

        //id = 0 表示不設定版型
        if ($this->id == 0 || !$this->params)
            return self::$tplParams = [];

        if (!self::$tplParams = json_decode($this->params, true)) {
            $this->error = '[Fail] ID: ' . $this->id . ' 的樣本參數格式不正確!';
            return false;
        }
        return self::$tplParams;
    }

    public function getRQParams() {
        return $this->rqParams;
    }

    public function checkRQParams($rqParams) {
        if (!$this->getRQField())
            return false;

        $this->rqParams = Validator::checkFormat($this->getRQField(), $rqParams);

        if (isset($this->rqParams['ValidatorError']) && $this->rqParams['ValidatorError'])
            $this->error = '[Fail] Template ID - ' . $this->id . ': ' . $this->rqParams['ValidatorError'];

        return $this;
    }
}