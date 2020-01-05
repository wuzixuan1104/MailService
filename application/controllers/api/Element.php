<?php

use Api\Table;

class Element extends API_Controller
{
    const TABLE = [
        'mail',
        'sender',
        'headerFooter',
        'template'
    ];

    public function __construct() {
        parent::__construct(false); //false 不需檢查是否有Token
    }

    public function doRest() {
        $retState = HTTP_OK;
        $errors = [];

        $table = $this->uri->segment(3);

        if (!in_array($table, self::TABLE))
            $this->output(HTTP_BAD_REQUEST, false, 
                '[Fail] table 只允許 mail, sender, headerFooter, template');

        switch (Input::method()) {
            case 'GET':

                break;
            case 'POST':
                if (!$posts = Input::post())
                    $this->output(HTTP_BAD_REQUEST, false, 
                        '[Fail] table: ' . $table . ' 請輸入參數！');

                isset($posts['content']) && $posts['content'] = Input::post('content', false);
                isset($posts['params']) && $posts['params'] = Input::post('params', false);

                if (!$data = Table::create($table)->insert($posts))
                    $this->output(HTTP_BAD_REQUEST, false, 
                        '[Fail] table: ' . $table . ' 新增資料失敗');
                
                $data = ['id' => $data];
                break;
            default:
                $retState = HTTP_METHOD_NOT_ALLOWED;
                break;
        }

        $this->output($retState, $data, $errors);
    }

}
