<?php
use Api\SendMail;
use Utilities\LineNotifyService;

abstract class Mail_Controller extends API_Controller
{
    public $factoryApi      = null;
    public $tplType         = null;
    public $sendMailService = null;
    public $return          = [];

    public function __construct($checkAuth = true) {
        parent::__construct($checkAuth);

        if (!$key = Input::requestHeader('key'))
            $this->output(
                HTTP_NOT_FOUND, false, 
                '[Fail] missing 1 params named "key", ex: ebs-acer-hotel or b2c-group'
            );

        if (!$this->isKeyExist($key))
            $this->output(
                HTTP_NOT_FOUND, false, 
                '[Fail] 參數 "key" 錯誤！找不到該路徑'
            );
        
      
        $this->sendMailService = new SendMail(Input::post(), Input::file());
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
            $posts = Input::post();
            $files = Input::file();

            if ($prepare = $this->sendMailService->prepare($data)) {
                if (!$data = $prepare->send()) {
                    \Log::error('信件發送錯誤', $data, $posts);

                    $msg = "[ERROR] " . (ENVIRONMENT != 'production' ? '測試站 - ' : '') . "發送信件失敗\r\n\r\n" . 
                            json_encode($posts) . "\r\n\r\n請求 IP：" . $this->ip . "\r\n樣板 Key：" . Input::requestHeader('key') . "\r\n日期時間：" . date('Y-m-d H:i:s');
                    
                    @LineNotifyService::sendTo(
                        ['message' => $msg], 
                        config('api', 'lineNotify', 'token'), 'mailChatroom'
                    );
                    
                    $this->output(HTTP_INTERNAL_SERVER_ERROR, false, '[Fail] send mail!');
                } 
            } else {
                $this->output(HTTP_BAD_REQUEST, false, '[Fail] prepare to send mail!');
            }
        } 

        !$data && $data = true;
        $this->output(HTTP_OK, $data, '');
    }


}
