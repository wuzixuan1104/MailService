<?php 

/* ------------------------------------------------------
 *  定義環境常數
 * ------------------------------------------------------ */

define('ENVIRONMENT', 'development');
// define('ENVIRONMENT', 'testing');
// define('ENVIRONMENT', 'production');


switch (ENVIRONMENT) {
  case 'development':
  case 'testing':
    ini_set('display_errors', 1);
    error_reporting(-1);
    break;

  case 'production':
    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
    break;
  default:
    exit('沒有設定正確的環境變數！');
}
