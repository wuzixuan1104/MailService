<?php 
namespace Api\Mail;

use \Services\MailService;
use \Services\BaseService;
use Api\Table;

class Send extends BaseService {
    private $mailBody = '';
    public $fromMail, $password, $fromName, $subject;
    public $params = [];
    public $files = [];

    public function __construct($params, $files = []) {
        if (!isset($this->CI) || !$this->CI)
            $this->CI = &get_instance();

        $this->params = $params;
        $this->files  = $files;
    }

    public function prepare($app) {
        $sender = $app->sender();

        //取得預設 Mail
        $d4Sender = Table::create('Sender')->find(1);
        $sender->fromMail && ($this->fromMail = $sender->fromMail) || $d4Sender['fromMail'];
        $sender->fromName && ($this->fromName = $sender->fromName) || $d4Sender['fromName'];  
        
        //等等刪除
        $this->password = 'shari1104';

        $this->subject  = $sender = $app->mail()->subject($this->params);

        $this->mailBody = $app->header()->html() . 
                          ($this->params['text'] ?? $app->template()->html()) .
                          $app->footer()->html();  

        return $this;
    }

    public function send() {
        $mailObj = MailService::create($this->fromMail, $this->password, $this->fromName)
                    ->setSubject($this->subject)
                    ->setBody($this->mailBody);

        //寄送方式
        $type = 'addTo';
        if (isset($this->params['type']) && in_array(trim($this->params['type']), ['bcc', 'cc'])) {
            $type = 'add' . trim(strtoupper($this->params['type']));
        }

        foreach ($this->params['receivers'] as $receiver) {
            if (!isset($receiver['email']))
                continue;
            $mailObj->$type($receiver['email'], $receiver['name'] ?? '');
        }
        
        //1. 本地檔案
        if (isset($this->files['attachments']) && $this->files['attachments']) {
            foreach ($this->files['attachments'] as $attach) {
                if ($attach['error'] == UPLOAD_ERR_OK)
                    $mailObj->addFile($attach['tmp_name'], $attach['name']);
            }
        }
        //2. 遠端檔案
        if (isset($this->params['attachmentUrls']) && $this->params['attachmentUrls']) {
            foreach ($this->params['attachmentUrls'] as $attach) {
                if (!isset($attach['url']) || !$attach['url'])
                    continue;

                $contentType = '';
                if ($ext = pathinfo($attach['url'], PATHINFO_EXTENSION))
                    config('extension', $ext) && $contentType = config('extension', $ext)[0];

                $mailObj->addFileUrl($attach['url'], $attach['name'] ?? '', $contentType);
            }
        }

        return $mailObj->send();
    }
}