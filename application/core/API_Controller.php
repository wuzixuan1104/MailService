<?php
use Api\AuthService;
use Services\Rest;
use Utilities\CacheService;

class API_Controller extends CI_Controller
{
    use Rest;

    public $errorStatus = 200;
    public $errors      = [];
    public $data        = false;
    public $serviceId   = 'SYS_MAIL';
    public $token_auth  = true;
    public $token       = null;
    public $getParms    = [];
    public $postParms   = [];

    public function __construct()
    {
        parent::__construct();

        if (!$this->checkSource()) {
            $this->output(HTTP_FORBIDDEN, false, ["Forbidden - ".$_SERVER['REMOTE_ADDR']]);
            exit();
        }
        if (ENVIRONMENT == 'production' && $_SERVER['HTTP_HOST'] == 'hcms.tripresso.com.tw' && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")) {
            $this->output(HTTP_BAD_REQUEST, false, ["please use HTTPS protocol on hcms api request"]);
            exit();
        }

        $this->cacheService = new CacheService();
        $this->cacheService->init($this);

        $this->authService = new AuthService(
            [],
            [],
            [
                'serviceId'    => $this->serviceId,
                'cacheService' => $this->cacheService,
            ]
        );

        $this->getParms  = $this->input->get();
        $this->postParms = $this->parseParams($this->input->post(NULL, TRUE));
        
        $this->token     = isset($this->getParms['token']) ? $this->getParms['token'] : (isset($this->postParms['token']) ? $this->postParms['token'] : '');
        
        if (!$this->authService->checkToken($this->token) && $this->token_auth) {
            $this->output(HTTP_UNAUTHORIZED, false, ["Unauthorized, please get access token first"]);
            exit();
        }
    }

    private function _cidr_match($ip, $range)
    {
        list($subnet, $bits) = explode('/', $range);
        $ip                  = ip2long($ip);
        $subnet              = ip2long($subnet);
        $mask                = -1 << (32 - $bits);
        $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
        return ($ip & $mask) == $subnet;
    }

    protected function checkSource()
    {
        $ip_filter = [
            '192.162.1.0/24',
            '192.168.1.0/16',
            '139.162.1.1/16',
            '192.168.133.1/24',
            '10.0.2.0/24',
            '10.101.1.0/24',
            '10.103.1.0/24',
            '172.17.0.0/24',
            '10.0.0.0/8',
            '60.248.26.145/32',
            '172.104.83.167/32',
            '139.162.96.140/32',
            '60.250.128.229',
        ];

        if (isset($_SERVER["REMOTE_ADDR"]) && $ip = $_SERVER["REMOTE_ADDR"]) {
            foreach ($ip_filter as $range) {
                if ($this->_cidr_match($ip, $range)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function parseParams($standardPost)
    {
        $postParms  = false;
        $standInput = file_get_contents("php://input");
        if ($standInput && $standInput != '') {
            if (!$postParms = json_decode($standInput, true)) {
                parse_str($standInput, $postParms); // method = PATCH的情況
                if (empty($postParms)) {
                    $postParms = false;
                }
            }
        }

        return $postParms ? $this->security->xss_clean($postParms) : $standardPost;
    }

    public function index($param = '')
    {
        $method = $this->input->server('REQUEST_METHOD');
        $this->rest($method, $param);
    }

    public function doRest($method, $param, $getParms, $postParms)
    {
        exit("you need override this function [doRest]!");
    }

    public function rest($method, $param)
    {
        $return = $this->doRest($method, $param, $this->getParms, $this->postParms);
        $this->output($return['retState'], $return['data'], $return['errors']);
    }

}
