<?php

class Auth extends API_Controller
{
    public function __construct() {
        parent::__construct(false); //false 不需檢查是否有Token
    }

    public function doRest() {
        $errors   = [];
        $data     = false;
        $retState = HTTP_OK;

        switch (Input::method()) {
            case 'GET':
                $data = $this->authService->getToken();
                break;
            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }

        $this->output($retState, $data, $errors);
    }

}
