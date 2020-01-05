<?php 
namespace Api;

use \Services\MailService;
use \Services\BaseService;

class Table extends BaseService {
  public $table;
  public $fields;

  public static function create($table) {
    return new Table($table);
  }

  public function __construct($table) {
    parent::__construct();

    if (!isset($this->CI) || !$this->CI)
      $this->CI = &get_instance();

    $this->table = $table;
  }

  public function column() {
    return $this->fields = $this->CI->db->list_fields($this->table);
  }

  public function find($id) {
    if (!$query = $this->CI->db->get_where($this->table, ['id' => $id], 1, 0))
      return false;
    return $query->row_array();
  }
}

//Api/Table::create()->find($id);