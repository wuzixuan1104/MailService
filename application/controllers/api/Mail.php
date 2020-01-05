<?php

use Api\Mail\App;

class Mail extends Mail_Controller
{   
    public function __construct() {
        parent::__construct(false);
    }

    public function doRest() {
        switch (Input::method()) {
            case 'POST':
                //依照key取得對應工廠的參數和版型
                $posts = Input::post();

                $this->_checkRQField($posts);
                
                $tplObj = $this->appMailServie->template();

                if ($field = $tplObj->getRQField()) {
                    if (!(isset($posts['tplParams']) && $posts['tplParams'])) {
                        $this->output(HTTP_BAD_REQUEST, false, '[Fail] 請傳入樣板參數！');
                    
                    } else {
                        $tplObj->checkRQParams($posts['tplParams']);
                        $tplObj->error && $this->output(HTTP_BAD_REQUEST, false, $tplObj->error);
                    }
                }
                return true;
                break;
                
            case 'GET':
                return $this->_formatRQField();
                break;

            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }
    }


    private function _formatRQField() {
        $subject = $this->appMailServie->mail()->subject;
        preg_match_all('/(\{([a-zA-Z0-9]*)\})/', $subject, $matches);
        
        $subjectParams = [];
        if (isset($matches[2]) && $matches[2]) {
            foreach ($matches[2] as $match)
                $match && $subjectParams[$match] = 'String';
        }

        $tplParams = $this->appMailServie->template()->getRQField();

        return [    
            'MailSubject' => $subject,
            'MailParams' => array_filter([ 
                'receivers' => [
                    [
                        'email'          => 'String',
                        'name:optional'  => 'String',
                    ]
                ],
                'subjectParams:optional' => $subjectParams,
                'tplParams' => $tplParams,
                'type:optional (default: to)'  => 'Enum|item:cc,bcc,to',
                'text'  =>  !$tplParams ? 'String' : false, //如果沒有樣板格式，可以傳入文字訊息
                'attachmentUrls:optional (POST)' => [
                    [
                        'url'           =>  'String',
                        'name:optional' => 'String',
                    ]
                ],
                'attachments:optional (FILE)'   => [
                    'name'      => 'Array',
                    'type'      => 'Array',
                    'tmp_name'  => 'Array',
                    'error'     => 'Array',
                    'size'      => 'Array'
                ]
            ]),
        ];
    }

    private function _checkRQField($posts) {
        if (!(isset($posts['receivers']) && is_array($posts['receivers']) && $posts['receivers']))
            $this->output(HTTP_BAD_REQUEST, false, '[Fail] 參數格式錯誤 "receivers"，型態：Array');

        if (isset($posts['type']) && $posts['type'] && !in_array($posts['type'], ['to', 'bcc', 'cc']))
            $this->output(HTTP_BAD_REQUEST, false, '[Fail] 參數格式錯誤 "type"，格式：to, bcc, cc');

        if (isset($posts['attachmentUrls']) && $posts['attachmentUrls'] && !is_array($posts['attachmentUrls']))
            $this->output(HTTP_BAD_REQUEST, false, '[Fail] 參數格式錯誤 "attachmentUrls"，型態：Array');
        
        if (isset($posts['tplParams']) && $posts['tplParams'] && !is_array($posts['tplParams']))
            $this->output(HTTP_BAD_REQUEST, false, '[Fail] 參數格式錯誤 "tplParams"，型態：Array');
    }
}


