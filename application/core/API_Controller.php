<?php
use Services\AuthService;
use Services\Rest;
use Utilities\CacheService;

abstract class API_Controller extends CI_Controller
{
    use Rest;

    public $errorStatus = HTTP_OK;
    public $errors      = [];
    public $serviceId   = 'SYS_MAIL';
    public $factoryPath         = null;

    public function __construct($checkAuth = true) {
        parent::__construct();

        if (!$this->checkSource())
            $this->output(HTTP_FORBIDDEN, false, ["Forbidden - ".$_SERVER['REMOTE_ADDR']]);

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

        if ($checkAuth) {
            if (!$this->authService->checkToken(Input::requestHeader('token')))
                $this->output(HTTP_UNAUTHORIZED, false, ['Unauthorized, please get access token first']);

            if (!$key = Input::post('key'))
                $this->output(HTTP_NOT_FOUND, false, ['missing 1 params named "key", ex: ebs-acer-hotel or b2c-group']);

            if (!$this->factoryPath = $this->isKeyExist($key))
                $this->output(HTTP_NOT_FOUND, false, ['params "key" is not allowed']);
        }
    }

    abstract public function doRest();

    public function rest() {
        $return = $this->doRest();
    }

    public function index() {
        $this->rest();
    }

    protected function isKeyExist($key) {
        if (!$path = array_map('trim', explode('-', $key)))
            return false;

        $file = array_pop($path);
        array_push($path, ucfirst($file));

        $path = implode(DIRECTORY_SEPARATOR, $path) . '.php';
        if (!file_exists(PATH_LIB . 'Api' . DIRECTORY_SEPARATOR . 'Factory' . DIRECTORY_SEPARATOR . $path))
            return false;

        //load factory file
        include_once($path);

        return $path;
    }

    protected function checkSource() {
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
            '127.0.0.1/1',
            // '60.250.128.229',
        ];

        if (!(isset($_SERVER["REMOTE_ADDR"]) && $ip = $_SERVER["REMOTE_ADDR"])) 
            return false;

        foreach ($ip_filter as $range)
            if ($this->_cidr_match($ip, $range))
                return true;

        return false;
    }

    private function _cidr_match($ip, $range) {
        list($subnet, $bits) = explode('/', $range);
        $ip                  = ip2long($ip);
        $subnet              = ip2long($subnet);
        $mask                = -1 << (32 - $bits);
        $subnet             &= $mask;
        return ($ip & $mask) == $subnet;
    }
}
