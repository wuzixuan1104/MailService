<?php
namespace Services;
/**
 * Rest Controller
 * Base Controller for restful style pattern
 */
trait Rest
{
    protected function output($state, $data, $errors)
    {
        header('Content-Type: application/json');

        http_response_code($state);

        $res = new \StdClass;

        if ($state == HTTP_OK)
            die (json_encode($data));

        if (in_array($state, [
            HTTP_INTERNAL_SERVER_ERROR, 
            HTTP_BAD_REQUEST, 
            HTTP_UNAUTHORIZED, 
            HTTP_NOT_FOUND
        ])) {
            $res->error = $errors;
        }

        die (json_encode($res));
    }
}
