<?php
namespace Api\Structure;

Interface MailInterface {
    public function getSubject();
    public function getView();
    public function getMailSecret();
}
