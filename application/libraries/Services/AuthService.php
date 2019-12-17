<?php
namespace Services;

use Services\BaseService;

class AuthService extends BaseService
{
    public function genToken($param = '', $length = 15, $hyphenate_len = 5)
    {
        // uniqid gives 15 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            return '';
        }

        $token = substr(bin2hex($bytes), 0, $length);
        return implode("-", str_split($token, $hyphenate_len));
    }

    public function getToken($param = '')
    {
        $ttl    = 86400;
        $expire = time() + $ttl;
        $token  = $this->genToken($param);
        $key    = $this->serviceId . ':API_TOKEN:' . $token;

        if ($this->cacheService->save($key, '1', $ttl)) {
            return [
                'token'  => $token,
                'expire' => $expire,
            ];
        }

        return false;
    }

    public function checkToken($token)
    {
        if (trim($token) == '') {
            return false;
        }

        return $this->cacheService->get($this->serviceId . ':API_TOKEN:' . $token);
    }

}
