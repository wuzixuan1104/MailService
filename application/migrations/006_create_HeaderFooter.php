<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_HeaderFooter extends CI_Migration {

  public function up() {
    if(!$this->db->table_exists('HeaderFooter')) {
  
      $this->dbforge->add_field("`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID' PRIMARY KEY"); 
      $this->dbforge->add_field("`type` enum('header', 'footer')  NOT NULL DEFAULT 'header' COMMENT '類型'"); 
      $this->dbforge->add_field("`title` varchar(50)  NOT NULL DEFAULT '' COMMENT '標題'"); 
      $this->dbforge->add_field("`pic` varchar(150)  NOT NULL DEFAULT '' COMMENT '圖示'"); 
      $this->dbforge->add_field("`content` text  NOT NULL  COMMENT 'html 內容'"); 
      $this->dbforge->add_field("`params` text  NOT NULL  COMMENT '參數'"); 
      $this->dbforge->add_field("`version` int(11)  NOT NULL DEFAULT 1 COMMENT '版本'"); 
      $this->dbforge->add_field("`createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間'"); 
      $this->dbforge->add_field("`updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'"); 

      return $this->dbforge->create_table('HeaderFooter');
    }
  }

  public function down() {
    return $this->dbforge->drop_table('HeaderFooter');
  }
}