<?php
namespace Api\Mail\Factory;

use Api\Validator;
use Api\Mail\Struct\TplInterface;
use Api\Table;

class HeaderFooter extends Factory implements TplInterface {
    const TABLE = 'HeaderFooter';

    static $field     = null;
    private $rqParams = [];

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
        //id = 0 表示不設定版型
        if ($this->id == 0 || !$this->params)
            return self::$field = [];

        if (!self::$field = json_decode($this->params, true)) {
            $this->error = '[Fail] HeaderFooter ID: ' . $this->id . ' 的參數格式不正確!';
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

        if (!$rqParams) {
            $this->error = '[Fail] HeaderFooter ID - ' . $this->id . ': 請於欄位中填入參數！';
            return $this;
        }

        if (!$rqParams = json_decode($rqParams, true)) {
            $this->error = '[Fail] HeaderFooter ID - ' . $this->id . ': 填入參數的 JSON 格式有誤！';
            return $this;
        }
     
        $this->rqParams = Validator::checkFormat(self::$field, $rqParams);
        if (isset($this->rqParams['ValidatorError']) && $this->rqParams['ValidatorError'])
            $this->error = '[Fail] HeaderFooter ID - ' . $this->id . ': ' . $this->rqParams['ValidatorError'];

        return $this;
    }
}