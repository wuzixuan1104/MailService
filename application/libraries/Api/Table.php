<?php 
namespace Api;

use \Services\MailService;
use \Services\BaseService;

class Table extends BaseService {
    public $table;
    public $fields;

    public static function create($table) {
        return new Table(ucfirst($table));
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

    public function findAll($params = [], $offset = 0, $limit = 20) {
        if (!$query = $this->CI->db->get_where($this->table, $params, $offset, $limit))
            return false;
        return $query->result_array();
    }

    public function insert($data) {
        if (!$column = $this->column())
            return false;

        foreach ($data as $k => $v) {
            if (!in_array($k, $column)) {
                unset($data[$k]);
                continue;
            }

            is_array($v) && $data[$k] = json_encode($v);

            if ($k != 'content' && $k != 'params') //此key允許html
                $data[$k] = trim($this->CI->db->escape($data[$k]), "'");
        }
        
        if ($this->CI->db->insert($this->table, $data))
            return $this->CI->db->insert_id();

        return false;
    }
}

