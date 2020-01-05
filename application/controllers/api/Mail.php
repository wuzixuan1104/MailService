<?php

use Api\Mail\App;

class Mail extends Mail_Controller
{   
    public function __construct() {
        parent::__construct(false);
    }

    public function doRest() {
        // $this->uri->segment(3);
        
        // $factory  = $this->factoryApi;
        // $obj = new $factory();
        
        // $classFunc = $this->tplType;
        // if (!method_exists($obj, $classFunc))
        //     $this->output(HTTP_BAD_REQUEST, false, "[Fail] 找不到 {$classFunc} 樣板！");


        switch (Input::method()) {
            case 'POST':
                //依照key取得對應工廠的參數和版型
                $posts = Input::post();

                // if (!(isset($posts['receivers']) && $posts['receivers']))
                //     $this->output(HTTP_BAD_REQUEST, false, 
                //         '[Fail] 參數缺少 "receivers"');

                // $obj = $obj->$classFunc($posts['tplParams']);
                
                // $rqParams = $obj->getRequiredParams();

                // if (isset($rqParams['ValidatorError']))
                //     $this->output(HTTP_BAD_REQUEST, false, $rqParams['ValidatorError']);
                
                // return $obj;
                break;
            case 'GET':

                $gets = Input::get();
                $app = new App($gets['mailId']);

                $app = $app->mail();

                print_r($app);
                die;

                return $this->_formatRQField($app);
                break;

            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }
    }

    private function _formatRQField($app) {
        // $subject = $factory->getSubject();
        // preg_match_all('/(\{([a-zA-Z0-9]*)\})/', $subject, $matches);
        
        // $subjectParams = [];
        // if (isset($matches[2]) && $matches[2]) {
        //     foreach ($matches[2] as $match)
        //         $match && $subjectParams[$match] = 'String';
        // }

        return [    
            '信件標題(subject)' => $subject,
            '樣板路徑(view)' => $factory->getView(),
            '參數格式(params)' => array_filter([ 
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


