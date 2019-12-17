<?php

class Auth extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->token_auth = false;
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

            case 'POST':
            case 'PUT':
            case 'DELETE':
            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }

        return ['retState' => $retState, 'data' => $data, 'errors' => $errors];
    }

}
