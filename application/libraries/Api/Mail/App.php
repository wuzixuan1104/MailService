<?php
namespace Api\Mail;

use Api\Mail\Factory\Mail;
use Api\Mail\Factory\Sender;
use Api\Mail\Factory\Template;
use Api\Mail\Factory\HeaderFooter;

class App {
  private $id;

  static $mailModel         = null;
  static $templateModel     = null;
  static $senderModel       = null;
  static $headerModel       = null;
  static $footerModel       = null;

  public function __construct($id) {
    $this->id = $id;
  }

  public function mail() {
    if (self::$mailModel !== null)
      return self::$mailModel;

    return self::$mailModel = new Mail($this->id);
  }

  public function template() {
    if (self::$templateModel !== null)
      return self::$templateModel;

    if (!$this->mail())
      return $this->mail();

    return self::$templateModel = new Template(self::$mailModel->templateId);
  }

  public function sender() {
    if (self::$senderModel !== null)
      return self::$senderModel;

    if (!$this->mail())
      return $this->mail();

    return self::$senderModel = new Sender(self::$mailModel->senderId);
  }

  public function header() {
    if (self::$headerModel !== null)
      return self::$headerModel;

    if (!$this->sender())
      return $this->sender();

    return self::$headerModel = (new HeaderFooter(self::$senderModel->headerId))
                                  ->checkRQParams(self::$senderModel->headerParams);
  }

  public function footer() {
    if (self::$footerModel !== null)
      return self::$footerModel;

    if (!$this->sender())
      return $this->sender();

    return self::$footerModel = (new HeaderFooter(self::$senderModel->footerId))
                                  ->checkRQParams(self::$senderModel->footerParams);
  }
}