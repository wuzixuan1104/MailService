<?php
namespace Services;
/**
 * Rest Controller
 * Base Controller for restful style pattern
 */
trait Rest
{
    protected $resp = '', $http = HTTP_NOT_FOUND;

    /**
     * 提供基本source schema給front-end
     * @return [type]
     */
    public function getSource($formName, $scenerio ='')
    {
        $ret = [];
        if (!empty($formName)) {
            $class = ucfirst($formName);
            if (!empty($scenerio)) {
                $c = new $class($scenerio);
            } else {
                $c = new $class();
            }

            $ret = $c->getJSON();
            echo $ret;
        }
    }

    protected function output($state, $data, $errors)
    {
        $res = new \StdClass;
        if ($state == 200) {
            http_response_code(200);
            if(!empty($data)) {
                echo json_encode($data);
            }
        } else if(
            $state == 500 ||
            $state == 400 ||
            $state == 401
            ) {
            http_response_code($state);
            $res->error = $errors;
            echo json_encode($res);
        } else if($state == 404) {
            http_response_code(404);
            $res->error = $errors;
            echo json_encode($res);
        } else {
            http_response_code($state);
            $res->error = $errors;
            echo json_encode($res);
        }
    }

    /** 
     * Send response
     */
    protected function sendResponse() {
        http_response_code($this->http);
        echo $this->resp;
    }

    protected function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function successResponse($resp, $http = HTTP_OK) {
        $this->resp = $resp;
        $this->http = $http;
    }

    protected function errorResponse($errorMsg = '', $http = HTTP_NOT_FOUND) {
        $this->resp = json_encode([
            'error' => $errorMsg,
        ]);
        $this->http = $http;
    }
}
