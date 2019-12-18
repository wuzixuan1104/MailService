## 發信系統

> 呼叫方式

+ URL: 在下方表格
+ method: 
    + 發信接口 -> `POST` 方法
    + 查看信件樣板參數 -> `GET` 方法
+ header: `key`, `token`

> 舉個例子吧！

+ 先取得 accessToken
    + url: `/api/auth`
     
+ **POST** 呼叫飯店確認信
    + `emails` 都為必帶值，才知道寄送給誰，多個逗號分隔
    
```
[
    'emails'    => 'shari.wu@tripsaas.com, sun.kuo@tripresso.com', //必填
    'orderCode' => 'H12334545',  //樣板所需參數
    'status'    => 'success',   //樣板所需參數
    'userInfo   => [
        'name' => 'Shari' //樣板所需參數
    ]
]
```

+ **GET** 查看飯店確認信參數格式
    + 回傳內容

```
{
    "orderCode": "String|max:100",
    "status": "String|max:50",
    "userInfo": {
        "name": "String"
    }
}
```

> KEY 總覽

### ebs - acer

| 樣板 | key | url |
| -------- | -------- | -------- |
| 飯店訂單確認信  |  ebs-acer-hotel    |  mail/order/confirm    |









