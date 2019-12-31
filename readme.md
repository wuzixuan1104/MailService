## 發信系統

### 寄送信件
+ url: `\api\mail`
+ method: **POST**
+ header: {key} 
    + 依照樣版格式填入 ex: `ebs-acer-hotel-order@confirm` - Acer 飯店訂單確認信

+ 請求參數

| 參數 | 型態 | 說明 |
| -------- | -------- |  -------- |
| receivers  |Array |  收件人    |
| receivers.emails |String | 收件人信箱| 
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
            "emails": "shari.wu@tripsaas.com",
            "name": "Shari Wu"
        },
        {
            "emails": "shari1104@tripresso.com",
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
+ header: {key} 
    + 依照樣版格式填入 ex: `ebs-acer-hotel-order@confirm` - Acer 飯店訂單確認信

    
```json=
{
    "subject (display title)": "Acer 飯店 - {title} 訂單成立 {orderCode}", //用大括號包起來的是可以變動的值
    "params (request format bellow)": { //以下才是參數格式
        "receivers": [ //發送人
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

> KEY 總覽 (尚未發布正式版)

### ebs - acer

| 樣板 | key | url |
| -------- | -------- | -------- |
| 飯店訂單確認信  |  ebs-acer-hotel-order@confirm |  api/mail    |


