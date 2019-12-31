<?php 
namespace Api;

use \Services\MailService;
use \Services\BaseService;

class SendMail extends BaseService {
    private $mailBody = '';
    public $username, $password, $fromName, $subject;
    public $params = [];
    public $files = [];

    public function __construct($params, $files = []) {
        if (!isset($this->CI) || !$this->CI)
            $this->CI = &get_instance();

        $this->params = $params;
        $this->files  = $files;
    }

    public function prepare($factory) {
        $mailSecret = $factory->getMailSecret();

        if (!($mailSecret && isset($mailSecret['username'], $mailSecret['password'], $mailSecret['fromName']) && 
            $mailSecret['username'] && $mailSecret['password']))
            return false;

        $view = $factory->getView();
        if (!$view || $view == null)
            return false;

        //內容套版
        $this->mailBody = $this->CI->load->view($factory->getView(), $factory->getRequiredParams(), true);
        if (!$this->mailBody || $this->mailBody == '')
            return false;

        $this->username = $mailSecret['username'];
        $this->password = $mailSecret['password'];
        $this->fromName = $mailSecret['fromName'];
        $this->subject  = $factory->getSubject();

        //信件標題套版
        if (isset($this->params['subjectParams']) && is_array($this->params['subjectParams']) && $this->params['subjectParams']) {
            foreach ($this->params['subjectParams'] as $k => $v)
                $this->subject = str_replace('{' . $k . '}', $v, $this->subject);
        }

        return $this;
    }

    public function send() {
        $mailObj = MailService::create($this->username, $this->password, $this->fromName)
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