<?php

class Auth extends API_Controller
{
    public function __construct()
    {
        parent::__construct(false); //false 不需檢查是否有Token
    }

    public function doRest($method, $param, $getParms, $postParms)
    {
        $errors   = [];
        $data     = false;
        $retState = HTTP_OK;

        switch ($method) {
            case 'GET':
                $type = $getParms['type'] ?? '';
                $data = $this->authService->getToken($type);
                break;
            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }

        $this->output($retState, $data, $errors);
    }

}
