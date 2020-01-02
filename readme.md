## 發信系統

## API
### 寄送信件
+ url: `\api\mail`
+ method: **POST**
+ header: 依照樣版格式填入 

```
{
    "key": "ebs-acer-hotel-order@confirm" //Acer 飯店訂單確認信
}
```

+ 請求參數

| 參數 | 型態 | 說明 |
| -------- | -------- |  -------- |
| receivers  |Array |  收件人    |
| receivers.email |String | 收件人信箱| 
| receivers.name |String |`optional` 收件人姓名| 
| subjectParams  |Array | `optional` 標題參數，裡面為不固定參數 |
| tplParams |Array | 樣版參數，裡面為不固定參數|
| type  | Enum: to,bbc,cc | `optional` 寄送類型，預設 `to` |
| attachmentUrls | Array    | `optional` 夾帶 url 檔案  |
| attachmentUrls. url | String  | url 檔案    |
| attachmentUrls. name | String | `optional` 檔案名稱   |
| attatchments |    Array | `optional` 夾帶檔案 |

 
```
[
    "receivers": [
        {
            "email": "shari.wu@tripsaas.com",
            "name": "Shari Wu"
        },
        {
            "email": "shari1104@tripresso.com",
            "name": "Shari"
        }
    ], 
    "subjectParams": {
        "title": "",
        "orderCode": "H123456789"
    },
    "tplParams": { 
        "orderCode": "H123456789",
        "status": "Success",
        "userInfo": {
            "name": "Shari",
            "phone": "09123123123"
        }
    },
    "type": "bcc",
    "attachmentUrls": [
        {
            "url": "https://dszfbyatv8d2t.cloudfront.net/linebot/crm/online/LineFile/file/00/00/00/05/857142150_5d27ecce347d0.pdf",
            "name": "PDF測試"
        }
    ]
]
```

+ 回應成功 `200`
    
```
true
``` 

+ 回應失敗
    
```
{
    "error": "[Fail] 找不到 create1 樣板！"
}
```
```
{
    "error": "[Fail] 參數 \"key\" 錯誤！找不到該路徑"
}
```
```
{
    "error": "[Fail] 參數缺少 \"receivers\"
}
```

### 查看樣版參數格式
+ url: `\api\mail`
+ method: **GET**
+ header: 依照樣版格式填入 

```
{
    "key": "ebs-acer-hotel-order@confirm" //Acer 飯店訂單確認信
}
```

+ 成功回應
    
```json=
{
    "信件標題(subject)": "Acer 飯店 - {title} 訂單成立 {orderCode}", //用大括號包起來的是可以變動的值
    "樣板路徑(view)": "edm/hotel/order/confirm/V1",
    "參數格式(params)": {
        "receivers": [ //收件人
            {
                "email": "String",
                "name:optional": "String" //非必填
            }
        ],
        "subjectParams:optional": { //標題參數
            "title": "String",
            "orderCode": "String"
        },
        "tplParams": { //樣板參數
            "orderCode": "String|max:100",
            "status": "String|max:10",
            "userInfo": {
                "name": "String|max:50",
                "phone:optional": "String" //非必填
            }
        },
        "type:optional (default: to)": "Enum|item:cc,bcc,to", //發送類型，預設 to
        "attachmentUrls:optional (POST)": [ //夾帶檔案 - url 類型，使用 POST 方式
            {
                "url": "String",
                "name:optional": "String" //非必填
            }
        ],
        "attachments:optional (FILE)": {//夾帶檔案 - file 類型，使用 FILE 方式
            "name": "Array",
            "type": "Array",
            "tmp_name": "Array",
            "error": "Array",
            "size": "Array"
        }
    }
}
```
## 程式

### Step1. 建立 env.php 檔案
+ 於 `/public` 資料夾根據 `env.example.php` 內容複製一份 `env.php` 檔案，並將所屬環境打開

```
define('ENVIRONMENT', 'development');
// define('ENVIRONMENT', 'testing');
// define('ENVIRONMENT', 'production');

```

### Step2. 建立 Config 

> `mailSecret.php` 放置私密寄件設定 (不加入版控)，請自行新增一份放置在所屬環境資料夾。

```
<?php

$config['default'] = [
    'host'      => 'smtp.gmail.com',
    'port'      => 587,
    'charset'   => 'utf-8',
    'encoding'  => 'base64',
    'secure'    => 'tls',
    'username'  => 'shari.wu@tripsaas.com',
    'password'  => '',
    'fromName'  => 'Shari.wu',
];

$config['ebs'] = [
    'acer' => [
        'username'  => 'shari.wu@tripsaas.com',
        'password'  => '',
        'fromName'  => 'Tripresso EBS 系統通知'
    ]
];
```

> `mail.php` 各個版型設定，可自行定義，分類好就行！

+ 底下 **view** 表示想使用的樣板路徑

     
```
<?php

$config['ebs'] = [
    'topic' => 'Tripresso EBS',
    'acer' => [
        'hotel' => [
            'subject' => 'Acer 飯店',
            'order' => [
                'create'  => [
                    'title'  => '{title} 訂單成立 {orderCode}',
                    'view'   => 'edm/hotel/order/confirm/V1',
                ],
                'confirm' => [
                    'title'  => '訂單確認',
                    'view'   => 'edm/hotel/order/confirm/V1',
                ],
            ],
            'apply'   => [
                'confirm' => [
                    'title'  => '團員申請確認',
                    'view'   => 'edm/hotel/apply/confirm/Member_v1',
                ],
                'review' => [
                    'title' => '審核測試',
                    'view'  =>  'edm/hotel/order/confirm/V1',
                ]
            ]
        ] 
    ]
];

$config['cts'] = [
    'topic' => 'Tripresso CTS',
    'hotel' => [
        'subject' => '差旅',
        'confirm' => [
            'title'  => '飯店訂單確認',
            'view'   => 'edm/hotel/order/confirm/V1',
        ],
    ] 
];
```

### Step3. 產生樣版
+ 每次建立樣板，都需要產生兩個檔案，分別是：
    + **{樣板路徑}** 需完全相同 

> HTML 樣板：`application/views/{樣板路徑}` <br>
> 樣板參數：`application/libraries/Api/Template/{樣板路徑}`

+ 兩者檔案路徑與檔名皆需相同，例如：

```
HTML 樣板: application/views/edm/hotel/apply/confirm/Member_v1.php
樣板參數:   application/libraries/Api/Template/edm/hotel/apply/confirm/Member_v1.php
```

+ HTML 樣板 - Member_v1.php

```
<div><?php echo $orderCode; ?></div>
```

+ 樣板參數 - Member_v1.php 
    + 以下程式直接雷同複製貼上即可，記得修改 `namespace` 及相關設定值
    + 補充：`requiredField()` 中的參數型態判斷需要符合 `Validator` 格式 (詳細請參考下方補充)

```
<?php
namespace Api\Template\edm\hotel\apply\confirm;

use Api\Template\Validator;
use Api\Structure\TemplateInterface;


class Member_v1 implements TemplateInterface {
    public $rqParams;

    public function __construct($params) {
        $params && $this->rqParams = Validator::checkFormat($this->requiredField(), $params);
    }

    public function requiredField() {
        return [
            'orderCode' => 'String|max:100',
        ];
    }

    public function getViewParams() {
        return isset($this->rqParams['ValidatorError']) ? $this->rqParams : 
        [
            'orderCode'  => $this->rqParams['orderCode'],
        ]; 
    }
}
```

### Step4. 製作信件工廠

+ 路徑：`application/libraries/Api/Factory/{KEY路徑}`

+ 在該路徑下建立一個自定義的工廠 (不限制資料夾怎麼放置)，ex: 建立 ebs系統內的 Acer 飯店申請信件類別
    + 我將它的檔案分類放置在：`application/libraries/Api/Factory/ebs/acer/hotel/Apply.php` 
    + 以下程式直接雷同複製貼上即可，記得修改 `namespace` 及相關設定值
    + 在檔案內建立一個 `confirm` 函式，表示為 `申請類別中的確認信件`
    + 可以組成 **KEY** 了!! 規則為 **KEY路徑@函式**
    + 此例子 KEY 為：`ebs-acer-hotel-order@confirm`

```
<?php
namespace Api\Factory\ebs\acer\hotel;
use Api\Structure\MailInterface;
use Api\Template\TplParamsResponse;

class Apply {
    public function confirm($params = []) { //確認信
        return new Confirm($params);
    }
    public function review($params = []) { //審核信
        return new Review($params);
    }
}

//定義確認信類別
class Confirm extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() { //在 config 中直接定義想取得的樣板，之後若想使用相同 KEY 但是不同樣板可以直接在 config/mail.php 設定
        return config('mail', 'ebs', 'acer', 'hotel', 'apply', 'confirm', 'view');
    }

    public function getSubject() { //在 config 中定義標題
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'apply', 'confirm', 'title');
    }

    public function getMailSecret() { //在 config 中設定寄信對象
        return config('mailSecret', 'ebs', 'acer');
    }
}

//定義審核信類別
class Review extends TplParamsResponse implements MailInterface {
    public function __construct($params) {
        parent::__construct($this->getView(), $params);
    }

    public function getView() {
        return config('mail', 'ebs', 'acer', 'hotel', 'apply', 'review', 'view');
    }

    public function getSubject() {
        return config('mail', 'ebs', 'acer', 'hotel', 'subject') . ' - ' . 
               config('mail', 'ebs', 'acer', 'hotel', 'apply', 'review', 'title');
    }

    public function getMailSecret() {
        return config('mailSecret', 'ebs', 'acer');
    }
}
```

### Step5. 大功告成

+ 開始使用 API (詳細說明請參閱 API 說明文)
    
## 補充

### KEY 總覽 (尚未發布正式版)

> ebs - acer

| 樣板 | key | url |
| -------- | -------- | -------- |
| 飯店訂單確認信  |  ebs-acer-hotel-order@confirm |  api/mail    |


### Validator 範例格式

+ 參數格式

```
$struct = [
      'name'  => 'String|max:100',
      'age'   => 'Integer|min:12|max:50',
      'sex'   => 'Enum|item:M,F',
      'hobbies:optional' => [
        'details:optional' => [
          [
            'title:optional'   => 'String|max:100',
            'freq:optional'    => 'Integer|min:1|max:100',
            'other:optional'   => [
              'name' => 'String|max:50'
            ]
          ]
        ],
        'total' => 'Integer',
      ],
      'contact:optional' => [
        'phone'      => 'String|min:1',
        'tel:optional'  => 'String|max:100',
      ],
      'childs:optional' => 'Array',
      'isCancel'    =>  'Bool',
      'updateAt:optional' => 'Datetime',
      'cancelDate:optional' => 'Date'
];
```

+ 傳入的參數範例

```
$input = [
      'name'  => 'Shari',
      'age'   => 24,
      'sex'   => 'F',
      'hobbies' => [
        'details' => [
          [
            'title' => 'Traveling',
            'freq'  => 2,
            'other' => [
              'name' => '最擅長',
            ]
          ],
          [
            'title' => 'Hiking',
            'freq'  => 1,
          ],
        ],
        'total' => 2
      ],
      'contact' => [
        'phone' => '0919123123',
        'tel'   => '2623123123'
      ],
      'childs' => [1,3,5],
      'isCancel' => true,
];
```

