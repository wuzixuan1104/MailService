
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
</head>

<body style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;background:#fff;margin:0 auto;">
    <table style="width:1000px;border-spacing:0px;margin:0 auto;" cellpadding="20">
        <tbody>
            <tr style="background:#eee;padding:5px;width:1000px;">
                <td>
                    <p style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;color:#fff;font-size:14px;font-weight:bold;margin:0;text-align: right;letter-spacing: 1px;color:#888;">
                        若您無法閱讀此信，請點
                        <a style=" color: #009688;text-decoration: none;" href="#">
                            這裡
                        </a>
                    </p>
                </td>
            </tr>
            <tr style="background:#83b817;padding:20px;width:1000px;">
                <td>
                    <p style="color:#fff;font-size:20px;font-weight:bold;margin:0;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                        <?php echo $title;?></p>
                </td>
            </tr>
            <tr style="width:1000px;">
                <td>
                    <div style="font-weight: 400;font-size: 20px;letter-spacing: 1px;color: #555;">
                        <p style="margin:0px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">團長 <span><?php echo $leader;?></span> ，請儘速確認團員的申請！
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="display:block;box-sizing:border-box;width:auto;height: auto;margin: 0 auto 40px;padding: 0px;border: none;border-collapse: inherit;border-spacing: 0px;border-color: inherit;font-weight: inherit;border: 1px solid #e0e5e9;border-radius: 4px 4px 0px 0px;width:1000px;color: #797979;"
        cellspacing="0" border="0" cellpadding="10">
        <tbody style="display: block;">
            <tr style="background: #fafafa;display: inline-block;box-sizing: border-box;border-radius: 4px 4px 0px 0px;font-size: 0px;font-weight: bold;width: 998px;">
                <td width="998" colspan="3" style="border-bottom: 1px solid #e0e5e9;width:998px;">
                    <table style="border-spacing:0px;margin:0px;width:978px;"cellspacing="0" border="0" cellpadding="10">
                        <tbody>
                            <tr>
                                <td style="color: #009688;display:inline-block;font-size: 18px;width:218px;padding: 0px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    <!-- 類別 -->
                                    <span styl="color: #009688;display:block;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">【HOTEL
                                    飯店揪團】</span>
                                    <!-- 【FLIGHT 機票揪團】【TOUR 團旅揪團】 -->
                                </td>
                                <td class="place-hotel" style="color: #009688;font-family: 'Microsoft JhengHei','微軟正黑體'!important;display:inline-block;font-size: 18px;width:500px;padding: 0px; padding: 0 0 0 15px;">
                                    <?php echo $hotelName;?>
                                    <span style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;color: #8b8b8b;font-weight: 500;font-size: 14px;padding: 0 0 0 10px;">
                                    <?php echo $place;?>
                                </span>
                                </td>
                                <td width="180" style="text-align:right;display:inline-block;font-size: 14px;width:180px;padding: 0px;color: #8b8b8b;font-weight: 500;font-size: 14px;letter-spacing: 1px;">
                                    <a href="#" style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;display:block;text-decoration: none;color: #8b8b8b;font-weight: 500;font-size: 14px;letter-spacing: 1px;">
                                    貼文編號：<?php echo $postNumber;?>
                                </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="display:block;background: #fefefe;font-size:0px;width: 998px;">
                <td width="320" style="width:320px;font-size: 16px;display: inline-block;margin: 0px;padding: 0px;border-right: 1px solid #e0e5e9;" rowspan="4">
                    <table cellpadding="10" style="font-weight: 400;letter-spacing: 1px;line-height: 30px;    border-spacing: 0px;display: block;" width="320" cellspacing="0" border="0">
                        <tbody>
                            <tr class="leader" style="display:block; margin:0 0 0 20px;">
                                <td colspan="2" style="display:inline-block;margin:0px;padding: 0px 10px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    團長<b>團長編號 / 姓名</b>早安！</td>
                            </tr>
                            <tr style="display:block; margin:0 0 0 20px;">
                                <td colspan="2" style="display:inline-block;margin:0px;padding: 0px 10px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    會員<b>申請團員編號 / 姓名</b></td>
                            </tr>
                            <tr style="display:block; margin:0 0 0 20px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                <td colspan="2" style="display:inline-block;margin:0px;padding: 0px 10px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    申請加入此團，是否同意？</td>
                            </tr>
                            <tr class="btn-block" style="display:block;font-size: 0px;text-align: center;margin:10px 30px 15px;">
                                <td style="width:120px;display:inline-block;color:#fff;text-decoration: none;text-align:center;background: #009688;display: inline-block;font-size: 18px;border-radius: 4px;padding: 5px 0;height:30px;font-weight: 500;margin: 0 10px 0 0;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    <a href="#" style="color: #fff;text-decoration: none;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">是</a>
                                </td>
                                <td style="width:120px;display:inline-block;color:#fff;background: none;color: #a3a0a0;text-decoration: none;border: 1px solid #a3a0a0;text-align:center;display: inline-block;font-size: 18px;border-radius: 4px;padding: 5px 0;font-weight: 500;height:28px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    <a href="#" class="decline" style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;color: #a3a0a0;text-decoration: none;">
                                        否
                                    </a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="297" style=" width: 297px; font-size: 16px;display: inline-block;margin: 0px;padding: 0px;" rowspan="4">
                    <table align="center" style="display: block;font-size: 0px;text-align: center;border-spacing: 0px;" width="297" cellspacing="5" border="0">
                        <tbody>
                            <tr class="check-in-date" style="display: inline-block;width: 300px;font-size: 16px;">
                                <td class="title" style=" width:110px;margin:0px auto;display:inline-block;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    入住日期
                                </td>
                                <td class="title" style="width:110px;margin:0px auto;display:inline-block;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                    退房日期
                                </td>

                            </tr>
                            <tr class="check-out-date" style="display: inline-block;width: 300px;font-size: 16px;">
                                <td class="calender" style="background: #fff;border-radius: 4px;width: 110px;border: 1px solid #e0e5e9;margin:0 auto;display:inline-block;" rowspan="3">
                                    <p style="background: #009588;color: #fff;padding: 6px;border-radius: 4px 4px 0px 0px;font-size: 13px;margin:0px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        <span>11</span> 月 /
                                        <span>2019</span>
                                    </p>
                                    <p style="font-size: 30px;margin:5px 0;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        8</p>
                                    <span class="day" style="  font-size: 15px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">星期四</span>
                                    <span class="time" style="display: block;font-size: 12px;padding: 2px 0px 8px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        17:00 pm
                                    </span>
                                </td>
                                <td class="calender" style="background: #fff;border-radius: 4px;width: 110px;border: 1px solid #e0e5e9;margin:0 auto;display:inline-block;" rowspan="3">
                                    <p class="month-year" style="background: #009588;color: #fff;padding: 6px;border-radius: 4px 4px 0px 0px;font-size: 13px;margin:0;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        <span>11</span>月 /
                                        <span>2019</span></p>
                                    <p style="font-size: 30px;margin:5px 0;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        15</p>
                                    <span class="day">星期四</span>
                                    <span style="display: block;font-size: 12px;padding: 2px 0px 8px;">
                                        17:00 pm
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="376" style=" font-size: 16px;display: inline-block;margin: 0px;padding: 0px; width: 376px;border-left: 1px solid #e0e5e9;" rowspan="4">
                    <table class="details-block" style="font-size: 14px;text-align:center;" width="376" cellspacing="0" border="0" align="center" cellpadding="5">
                        <tbody>
                            <tr>
                                <td>
                                    <p style="margin:0px;font-size: 16px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        入住幾天： <span>3</span> 晚</p>
                                </td>
                                <td>
                                    <p style="margin:0px;font-size: 16px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        需求人數： <span>10</span> 人</p>
                                </td>
                            </tr>
                            <tr style="background:#009588;color:#fff;">
                                <td colspan="2">
                                    <p style="margin:0px;font-size: 16px;font-family: 'Microsoft JhengHei','微軟正黑體'!important;">
                                        目前團員</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="margin:0;list-style: none;width:165px;">
                                    <span class="leader" style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;font-size: 16px;display: block;border-radius: 4px;border: 1px solid #009688;color: #009688;padding: 2px 10px; margin: 5px;">
                                        TR0232 / 曾輔君</span>
                                </td>
                                <td style="margin:0;list-style: none;width:165px;">
                                    <span style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;font-size: 16px;display: block;border-radius: 4px;border: 1px solid #009688;color: #009688;padding: 2px 10px; margin: 5px;">
                                        TR9827 / 陳碧珍</span>
                                </td>
                            </tr>
                            <tr>

                                <td style="margin:0;list-style: none;width:165px;">
                                    <span style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;font-size: 16px;display: block;border-radius: 4px;border: 1px solid #009688;color: #009688;padding: 2px 10px; margin: 5px;">TR3456
                                        / 吳姿萱</span>
                                </td>
                                <td style="margin:0;list-style: none;width:165px;">
                                    <span style="font-family: 'Microsoft JhengHei','微軟正黑體'!important;font-size: 16px;display: block;border-radius: 4px;border: 1px solid #009688;color: #009688;padding: 2px 10px; margin: 5px;">TR9220
                                        / 林育辰</span></td>
                            </tr>


                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="border-spacing:0px;background: #323232; width:1000px;color:#fff;margin:0 auto;" cellpadding="20">
        <tbody>
            <tr>
                <td>© 2019 Acer Inc.</td>
            </tr>
        </tbody>
    </table>
</body>

</html>