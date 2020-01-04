<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_Sender extends CI_Migration {

  public function up() {
    if(!$this->db->table_exists('Sender')) {
      
      $this->dbforge->add_field("`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID' PRIMARY KEY"); 
      $this->dbforge->add_field("`source` enum('ebs','cts','b2c','b2b')  NOT NULL DEFAULT 'b2c' COMMENT '來源'"); 
      $this->dbforge->add_field("`type` varchar(50)  NOT NULL DEFAULT '' COMMENT '子類別'"); 
      $this->dbforge->add_field("`fromMail` varchar(50)  NOT NULL DEFAULT '' COMMENT '來源名稱'"); 
      $this->dbforge->add_field("`fromName` varchar(50)  NOT NULL DEFAULT '' COMMENT '來源信件'"); 
      $this->dbforge->add_field("`createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間'"); 
      $this->dbforge->add_field("`updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'"); 

      return $this->dbforge->create_table('Sender');
    }
  }

  public function down() {
    return $this->dbforge->drop_table('Sender');
  }
}