<?php
namespace Service\Utilities;

class LineNotifyService
{
    public static $api_url  = 'https://notify-api.line.me/api/notify';
    public static $token    = '';
    public static $show_log = false;

    public static $client_id          = '';
    public static $secret             = '';
    public static $auth_callback_url  = '';

    public static function initOAuth2($options)
    {
        self::$client_id          = isset($options['client_id']) ? $options['client_id'] : '';
        self::$secret             = isset($options['secret']) ? $options['secret'] : '';
        self::$auth_callback_url  = isset($options['auth_callback_url']) ? $options['auth_callback_url'] : '';
    }

    public static function getOAuth2Url($state = '')
    {
        if (self::$client_id == '') {
            return false;
        }

        $options = [
            'response_type' => 'code',
            'client_id'     => self::$client_id,
            'redirect_uri'  => self::$auth_callback_url,
            'scope'         => 'notify',
            'state'         => $state,
        ];
        return 'https://notify-bot.line.me/oauth/authorize?' . http_build_query($options);
    }

    public static function getUserToken($code)
    {
        $opts    = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'content' => http_build_query([
                    'grant_type'    => 'authorization_code',
                    'code'          => $code,
                    'redirect_uri'  => self::$auth_callback_url,
                    'client_id'     => self::$client_id,
                    'client_secret' => self::$secret,
                ]),
            ],
        ];

        $context = stream_context_create($opts);
        if ($result = file_get_contents('https://notify-bot.line.me/oauth/token', false, $context)) {
            $result = json_decode($result, true);
            if (!isset($result['access_token'])) {
                self::log('no data!');
                return false;
            } else {
                return $result['access_token'];
            }
        }

        return false;
    }

    public static function setToken($token)
    {
        self::$token = $token;
    }

    public static function makeContentByFormUrlencoded($options)
    {
        return [
            'header' => "Content-type: application/x-www-form-urlencoded\n",
            'body'   => http_build_query($options),
        ];
    }

    public static function makeContentByFormData($options)
    {
        if (!file_exists($options['imageFile'])) {
            self::log('image file not exists! - ' . $options['imageFile']);
            return false;
        }
        $image_file = $options['imageFile'];
        unset($options['imageFile']);

        $multipart_boundary = '--------------------------' . microtime(true);

        $body = '';
        foreach ($options as $key => $val) {
            $body .= "--" . $multipart_boundary . "\r\n" .
                "Content-Disposition: form-data; name=\"" . $key . "\"\r\n\r\n" .
                $val . "\r\n";
        }

        $body .= "--" . $multipart_boundary . "\r\n" .
        "Content-Disposition: form-data; name=\"imageFile\"; filename=\"" . basename($image_file) . "\"\r\n" .
        "Content-Type: image/jpeg\r\n\r\n" .
        file_get_contents($image_file) . "\r\n";

        // signal end of request (note the trailing "--")
        $body .= "--" . $multipart_boundary . "--\r\n";

        return [
            'header' => "Content-type: multipart/form-data; boundary=" . $multipart_boundary . "\n",
            'body'   => $body,
        ];
    }

    public static function sendTo($options, $list, $to)
    {
        foreach ($list as $key => $token) {
            if ($to == 'all' || $to == $key || (is_array($to) && in_array($key, $to))) {
                self::send($options, $token);
            }
        }
    }

    /**
      * @param $options mixed message          = 文字訊息(必須值)
      *                       imageThumbnail   = 縮圖 (如果指定縮圖, imageFullsize為必須值)
      *                       imageFullsize    = 完整大圖 (如果指定大圖. imageThumbnail為必須值)
      *                       imageFile        = 上傳圖檔 (如果指定imageFile, imageThumbnail / imageFullsize無效)
      *                       stickerPackageId = 貼圖包id (ref:https://devdocs.line.me/files/sticker_list.pdf)
      *                       stickerId        = 貼圖id
      */
    public static function send($options, $token = '')
    {
        if ($token != '') {
            self::setToken($token);
        }

        if (self::$token == '') {
            self::log('token not set!');
            return false;
        }

        if (!isset($options['message'])) {
            self::log('message not set!');
            return false;
        }

        $content = isset($options['imageFile']) ? self::makeContentByFormData($options) : self::makeContentByFormUrlencoded($options);
        if (!$content) {
            return false;
        }

        $opts = [
            'http' => [
                'ignore_errors' => true,
                'method'        => 'POST',
                'header'        => $content['header'] .
                                   "Authorization: Bearer " . self::$token . "\n",
                'content'       => $content['body'],
            ],
        ];
        $context = stream_context_create($opts);
        if ($result = file_get_contents(self::$api_url, false, $context)) {
            $result = json_decode($result, true);
            if ($result['status'] != 200) {
                self::log('status = ' . $result['status'] . ', msg = ' . $result['message']);
                return false;
            } else {
                return true;
            }
        }

        return false;

    }

    public static function log($message)
    {
        if (!self::$show_log) {
            return;
        }
        echo $message . "\n";
    }
}

