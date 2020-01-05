<?php
use Api\Mail\Send as SendMail;
use Api\Mail\App as AppMail;
use Api\Table;
use Utilities\LineNotifyService;

abstract class Mail_Controller extends API_Controller
{
    public $factoryApi      = null;
    public $tplType         = null;
    public $sendMailService = null;
    public $return          = [];
    public $envTxt          = [];

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
            return $mail;

        $template = $this->appMailServie->template();
        if ($template->error || ($tplParams = $template->getRQField()) === false)
            return $template;

        $sender = $this->appMailServie->sender();
        if ($sender->error)
            return $sender;

        $header = $this->appMailServie->header();
        if ($header->error)
            return $header;

        $footer = $this->appMailServie->footer();
        if ($footer->error)
            return $footer;

        return true;
    }

    public function index() {
        $data = $this->doRest();

        if ($data === true) {
            $posts = Input::post();
            $files = Input::file();

            $logParams = ['mailId' => $this->uri->segment(3), 'ip' => $this->ip, 'params' => $posts];

            if ($prepare = $this->sendMailService->prepare($this->appMailServie)) {
                
                if (!$data = $prepare->send()) {
                    $msg = "[ERROR] 發送信件失敗\r\n\r\n" . 
                            json_encode($posts) . "\r\n\r\n請求 IP：" . $this->ip . "\r\n樣板 Key：" . Input::requestHeader('key') . "\r\n日期時間：" . date('Y-m-d H:i:s');
                    
                    @LineNotifyService::sendTo(
                        ['message' => $msg], 
                        config('api', 'lineNotify', 'token'), 'mailChatroom'
                    );
                    
                    Table::create('Log')->insert(array_merge($logParams, ['status' => 0]));
                    
                    $this->output(HTTP_INTERNAL_SERVER_ERROR, false, '[Fail] send mail!');
                } 
                Table::create('Log')->insert(array_merge($logParams, ['status' => 1]));

            } else {
                Table::create('Log')->insert(array_merge($logParams, ['status' => 0]));

                $this->output(HTTP_BAD_REQUEST, false, '[Fail] prepare to send mail!');
            }
        } 

        !$data && $data = true;
        $this->output(HTTP_OK, $data, '');
    }
}
