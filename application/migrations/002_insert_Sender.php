<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_insert_Sender extends CI_Migration {

  public function up() {
    if($this->db->table_exists('Sender')) {

      $data = [
        [
          'source'   => "b2c",
          'type'     => "default",
          'fromMail' => "service@tripresso.com",
          'fromName' => "Tripresso 系統通知信"
        ]
      ];
      
      return $this->db->insert_batch('Sender', $data);
    }
    
  }

  public function down() {
    $this->db->where('id', "1");
    $this->db->delete('Sender');
    
    return $this->db->affected_rows();
  }
}