<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_Log extends CI_Migration {

  public function up() {
    if(!$this->db->table_exists('Log')) {

      $this->dbforge->add_field("`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID' PRIMARY KEY"); 
      $this->dbforge->add_field("`mailId` int(11)  NOT NULL DEFAULT 0 COMMENT '信件 ID'"); 
      $this->dbforge->add_field("`status` tinyint(1)  NOT NULL DEFAULT 0 COMMENT '狀態，0: 失敗 1: 成功'"); 
      $this->dbforge->add_field("`ip` varchar(50)  NOT NULL DEFAULT '' COMMENT '呼叫來源IP位址'"); 
      $this->dbforge->add_field("`params` text  NOT NULL  COMMENT '參數'"); 
      $this->dbforge->add_field("`createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間'"); 
      $this->dbforge->add_field("`updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'"); 


      return $this->dbforge->create_table('Log');
    }
  }

  public function down() {
    return $this->dbforge->drop_table('Log');
  }
}