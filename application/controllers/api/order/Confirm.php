<?php

class Confirm extends Mail_Controller
{   
    public function __construct() {
        parent::__construct();
    }

    public function doRest() {
        $factory  = $this->factoryApi;

        switch (Input::method()) {
            case 'POST':
                //依照key取得對應工廠的參數和版型
                $confirmObj = (new $factory())->confirm(Input::post());

                if (isset($confirmObj->rqParams['ValidatorError'])) {
                    $this->output(
                        HTTP_BAD_REQUEST, false, 
                        $confirmObj->rqParams['ValidatorError']
                    );
                }
                return $confirmObj;
                break;

            case 'GET':
                //方便取得參數格式
                return (new $factory())->confirm()->requiredField();
                break;

            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }
    }
}


