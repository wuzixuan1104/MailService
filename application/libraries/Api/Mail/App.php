<?php
namespace Api\Mail;

use Api\Mail\Factory\Mail;
use Api\Mail\Factory\Sender;
use Api\Mail\Factory\Template;

class App {
  private $id;

  static $mailModel         = null;
  static $templateModel     = null;
  static $senderModel       = null;
  static $headerModel       = null;
  static $footerModel       = null;

  public function __construct($id) {
    $this->id = $id;
    if (!$this->mail())
      return $this->mail;
  }

  public function mail() {
    if (self::$mailModel !== null)
      return self::$mailModel;

    return self::$mailModel = new Mail($this->id);
  }

  public function template() {
    if (self::$templateModel !== null)
      return self::$templateModel;

    if (self::$mailModel == null || self::$mailModel->error)
      return $this->mail();

    return self::$templateModel = new Template(self::$mailModel->templateId);
  }

  public function sender() {
    if (self::$senderModel !== null)
      return self::$senderModel;

    if (self::$mailModel == null || self::$mailModel->error)
      return $this->mail();

    return self::$senderModel = new Template(self::$mailModel->senderId);
  }

  public function header() {
    if (self::$headerModel !== null)
      return self::$headerModel;

    if (self::$senderModel == null || self::$senderModel->error)
      return $this->sender();

    return self::$headerModel = (new HeaderFooter(self::$senderModel->headerId))
                                  ->setParams(self::$senderModel->headerParams);
  }

  public function footer() {
    if (self::$footerModel !== null)
      return self::$footerModel;

    if (self::$senderModel == null || self::$senderModel->error)
      return $this->sender();

    return self::$footerModel = (new HeaderFooter(self::$senderModel->footerId))
                                  ->setParams(self::$senderModel->footerParams);
  }
}