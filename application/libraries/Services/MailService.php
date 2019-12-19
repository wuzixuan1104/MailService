<?php
namespace Services;

use \PHPMailer;
use \SMTP;

class MailService extends PHPMailer {

    public static function create($username = null, $password = null, $fromName = null) {
        $username !== null || $username = config('mailSecret', 'default', 'username');
        $password !== null || $password = config('mailSecret', 'default', 'password');
        $fromName !== null || $fromName = config('mailSecret', 'default', 'fromName');

        if (!$username || !$password)
            return false;

        return new static($username, $password, $fromName);
    }

    public function __construct($username, $password, $fromName) {
        parent::__construct();

        $config = config('mailSecret', 'default');
        
        if (!isset($config['host'], $config['port'], $config['charset'], $config['encoding'], $config['secure']))
            return false;

        $this->isSMTP();
        $this->SMTPAuth = true;

        $this->Username = $username;
        $this->Password = $password;
        $this->FromName = $fromName;

        $this->From = $username;
        $this->isHTML(true);
        $this->WordWrap = 50;

        $this->Host     = $config['host'];
        $this->Port     = $config['port'];
        $this->CharSet  = $config['charset'];
        $this->Encoding = $config['encoding'];

        if ($config['secure'])
            $this->SMTPSecure = $config['secure'];
        else
            $this->smtpConnect(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]]);
    }

    public function addTo($address, $name = '') {
        $this->addAddress($address, $name);
        return $this;
    }

    public function addCC($address, $name = '') {
        parent::addCC($address, $name);
        return $this;
    }

    public function addBCC($address, $name = '') {
        parent::addBCC($address, $name);
        return $this;
    }

    public function addFile($path, $name = '') {
        $this->addAttachment($path, $name);
        return $this;
    }

    public function setSubject($subject) {
        $this->Subject = (ENVIRONMENT == 'production' ? '' : '測試站 - ') . $subject;
        return $this;
    }

    public function setBody($body) {
        $this->Body = $body;
        return $this;
    }

    public function setFrom($address, $name = '', $auto = true) {
        parent::setFrom($address, $name, $auto);
        return $this;
    }

    public function send() {
        return parent::send();
    }
}