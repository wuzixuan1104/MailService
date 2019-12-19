<?php 
namespace Api\Template;

class TplParamsResponse {
    protected $tplApiObj;

    public function __construct($view, $params) {
        $tplApi = 'Api\\Template\\' . str_replace('/', '\\', $view);
        $this->tplApiObj = new $tplApi($params);
    }

    public function getRequiredField() {
        if ($this->tplApiObj == null)
            return false;
        return $this->tplApiObj->requiredField();
    }

    public function getRequiredParams() {
        if ($this->tplApiObj == null)
            return false;
        return $this->tplApiObj->getViewParams();
    }

}