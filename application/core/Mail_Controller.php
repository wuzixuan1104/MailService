<?php
use Api\Mail\Send as SendMail;
use Api\Mail\App as AppMail;
use Utilities\LineNotifyService;

abstract class Mail_Controller extends API_Controller
{
    public $factoryApi      = null;
    public $tplType         = null;
    public $sendMailService = null;
    public $return          = [];

    public function __construct($checkAuth = true) {
        parent::__construct($checkAuth);
      
        $this->sendMailService = new SendMail(Input::post(), Input::file());
        
        if (!$this->uri->segment(3))
            $this->output(HTTP_BAD_REQUEST, false, '[Fail] URL 缺少信件 ID');

        $this->appMailServie = new AppMail($this->uri->segment(3));

        $check = $this->checkAppMail();
        if ($check !== true)
            $this->output(HTTP_BAD_REQUEST, false, $check->error);


        $this->return = ['retState' => HTTP_OK, 'data' => false, 'errors' => []];
    }

    public function checkAppMail() {
         //檢查信件是否存在
        $mail = $this->appMailServie->mail();
        if ($mail->error)
            return $mail->error;


        $template = $this->appMailServie->template();
        if ($template->error || ($tplParams = $template->getRQField()) === false)
            return $template->error;


        $sender = $this->appMailServie->sender();
        if ($sender->error)
            return $sender->error;

        return true;
    }

    public function index() {
        $data = $this->doRest();

        if ($data === true) {
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
