<?php

class Mail extends Mail_Controller
{   
    public function __construct() {
        parent::__construct(false);
    }

    public function doRest() {
        $factory  = $this->factoryApi;
        $obj = new $factory();
        
        $classFunc = $this->tplType;
        if (!method_exists($obj, $classFunc))
            $this->output(HTTP_BAD_REQUEST, false, "[Fail] 找不到 {$classFunc} 樣板！");


        switch (Input::method()) {
            case 'POST':
                //依照key取得對應工廠的參數和版型
                $posts = Input::post();

                if (!(isset($posts['receivers']) && $posts['receivers']))
                    $this->output(HTTP_BAD_REQUEST, false, 
                        '[Fail] 參數缺少 "receivers", 多個信箱請逗號隔開 ex:shari.wu@tripsaas.com, sun.kuo@tripsaas.com');

                $obj = $obj->$classFunc($posts['tplParams']);
                
                $rqParams = $obj->getRequiredParams();

                if (isset($rqParams['ValidatorError']))
                    $this->output(HTTP_BAD_REQUEST, false, $rqParams['ValidatorError']);
                
                return $obj;
                break;
            case 'GET':
                //方便取得參數格式
                return $this->_formatRQField($obj->$classFunc());
                break;

            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }
    }

    private function _formatRQField($factory) {
        $subject = $factory->getSubject();
        preg_match_all('/(\{([a-zA-Z0-9]*)\})/', $subject, $matches);
        
        $subjectParams = [];
        if (isset($matches[2]) && $matches[2]) {
            foreach ($matches[2] as $match)
                $match && $subjectParams[$match] = 'String';
        }

        return [    
            'subject (display title)' => $subject,
            'params (request format bellow)' => array_filter([ 
                'receivers' => [
                    [
                        'email'          => 'String',
                        'name:optional'  => 'String',
                    ]
                ],
                'subjectParams:optional' => $subjectParams,
                'tplParams' => $factory->getRequiredField(),
                'type:optional (default: to)'  => 'Enum|item:cc,bcc,to',
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
            ])
        ];
    }
}


