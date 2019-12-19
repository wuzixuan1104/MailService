<?php 
namespace Api;

use \Services\MailService;
use \Services\BaseService;

class SendMail extends BaseService {
    private $mailBody = '';
    public $username, $password, $fromName, $subject;

    public function __construct() {
        if (!isset($this->CI) || !$this->CI)
            $this->CI = &get_instance();
    }

    public function prepare($factory) {
        $mailSecret = $factory->getMailSecret();

        if (!($mailSecret && isset($mailSecret['username'], $mailSecret['password'], $mailSecret['fromName']) && 
            $mailSecret['username'] && $mailSecret['password']))
            return false;

        $view = $factory->getView();
        if (!$view || $view == null)
            return false;


        $this->mailBody = $this->CI->load->view($factory->getView(), $factory->getRequiredParams(), true);
        if (!$this->mailBody || $this->mailBody == '')
            return false;

        $this->username = $mailSecret['username'];
        $this->password = $mailSecret['password'];
        $this->fromName = $mailSecret['fromName'];
        $this->subject  = $factory->getSubject();

        return $this;
    }

    public function send($emails) {
        $emails  = array_map('trim', explode(',', $emails));
        $mailObj = MailService::create($this->username, $this->password, $this->fromName)
                    ->setSubject($this->subject)
                    ->setBody($this->mailBody);

        foreach ($emails as $email)
            $mailObj->addTo($email);
        
        if ($mailObj)
            return $mailObj->send();

        return false;
    }
}