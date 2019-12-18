<?php

class Confirm extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function doRest() {
        $errors   = [];
        $data     = false;
        $retState = HTTP_OK;

        switch (Input::method()) {
            case 'POST':
                $data = $this->post();
                // $data = $this->authService->getToken();
                break;
            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }

        $this->output($retState, $data, $errors);
    }

    private function post() {

    }

}
