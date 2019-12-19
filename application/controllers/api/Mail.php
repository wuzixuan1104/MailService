<?php

class Mail extends Mail_Controller
{   
    public function __construct() {
        parent::__construct();
    }

    public function doRest() {
        $factory  = $this->factoryApi;
        $obj = new $factory();
        
        $classFunc = $this->tplType;
        if (!method_exists($obj, $classFunc))
            $this->output(HTTP_BAD_REQUEST, false, '[Fail] 找不到樣板');


        switch (Input::method()) {
            case 'POST':
                //依照key取得對應工廠的參數和版型
                $obj = $obj->$classFunc(Input::post());
                
                $rqParams = $obj->getRequiredParams();
                if (isset($rqParams['ValidatorError'])) {
                    $this->output(HTTP_BAD_REQUEST, false, $rqParams['ValidatorError']);
                }
                
                return $obj;
                break;
            case 'GET':
                //方便取得參數格式
                return $obj->$classFunc()->getRequiredField();
                break;

            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }
    }
}


