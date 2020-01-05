<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_Template extends CI_Migration {

  public function up() {
    if(!$this->db->table_exists('Template')) {
  
      $this->dbforge->add_field("`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID' PRIMARY KEY"); 
      $this->dbforge->add_field("`type` enum('飯店','團體','機票','票卷', '通知', '其他')  NOT NULL DEFAULT '其他' COMMENT '類型'"); 
      $this->dbforge->add_field("`subType` varchar(50)  NOT NULL DEFAULT '' COMMENT '子類型'"); 
      $this->dbforge->add_field("`title` varchar(50)  NOT NULL DEFAULT '' COMMENT '標題'"); 
      $this->dbforge->add_field("`pic` varchar(150)  NOT NULL DEFAULT '' COMMENT '圖示'"); 
      $this->dbforge->add_field("`content` text  NOT NULL  COMMENT 'html 內容'"); 
      $this->dbforge->add_field("`params` text  NOT NULL  COMMENT '參數'"); 
      $this->dbforge->add_field("`version` int(11)  NOT NULL DEFAULT 0 COMMENT '版本'"); 
      $this->dbforge->add_field("`createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間'"); 
      $this->dbforge->add_field("`updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'"); 

      return $this->dbforge->create_table('Template');
    }
  }

  public function down() {
    return $this->dbforge->drop_table('Template');
  }
}