<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_Mail extends CI_Migration {

  public function up() {
    if(!$this->db->table_exists('Mail')) {
  
      $this->dbforge->add_field("`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID' PRIMARY KEY"); 
      $this->dbforge->add_field("`templateId` int(11) unsigned NOT NULL COMMENT '樣板 ID'"); 
      $this->dbforge->add_field("`senderId` int(11) unsigned NOT NULL COMMENT '寄件 ID' "); 
      $this->dbforge->add_field("`subject` varchar(100)  NOT NULL DEFAULT '' COMMENT '標題'"); 
      $this->dbforge->add_field("`createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間'"); 
      $this->dbforge->add_field("`updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'"); 

      return $this->dbforge->create_table('Mail');
    }
  }

  public function down() {
    return $this->dbforge->drop_table('Mail');
  }
}