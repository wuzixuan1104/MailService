<?php
use Api\SendMail;

abstract class Mail_Controller extends API_Controller
{
    public $factoryApi      = null;
    public $tplType         = null;
    public $sendMailService = null;
    public $return          = [];

    public function __construct($checkAuth = true) {
        parent::__construct();

        if (!$key = Input::requestHeader('key'))
            $this->output(
                HTTP_NOT_FOUND, false, 
                '[Fail] missing 1 params named "key", ex: ebs-acer-hotel or b2c-group'
            );

        if (!$this->isKeyExist($key))
            $this->output(
                HTTP_NOT_FOUND, false, 
                '[Fail] params "key" is not allowed'
            );
    
        $this->sendMailService = new SendMail();
        $this->return = ['retState' => HTTP_OK, 'data' => false, 'errors' => []];
    }

    protected function isKeyExist($key) {
        $keys = explode('@', $key);
        if (count($keys) != 2)
            return false;

        $this->tplType = end($keys);
        if (!$path = array_map('trim', explode('-', str_replace('@' . $this->tplType, '', $key))))
            return false;

        $file = array_pop($path);
        array_push($path, ucfirst($file));

        $path = 'Api' . DIRECTORY_SEPARATOR . 'Factory' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path);

        $factoryFile = PATH_LIB . $path . '.php';
        if (!file_exists($factoryFile))
            return false;

        include_once($factoryFile);

        $this->factoryApi = str_replace('/', '\\', $path);
        return true;
    }

    public function index() {
        $data = $this->doRest();

        if (is_object($data)) {
            if ($prepare = $this->sendMailService->prepare($data)) {
                if (!$data = $prepare->send(Input::post('emails'))) {
                    $this->output(
                        HTTP_INTERNAL_SERVER_ERROR, false, 
                        '[Fail] send mail!'
                    );
                } 
            } else {
                $this->output(
                    HTTP_BAD_REQUEST, false, 
                    '[Fail] prepare to send mail!'
                );
            }
        } 

        !$data && $data = true;
        $this->output(HTTP_OK, $data, '');
    }


}
