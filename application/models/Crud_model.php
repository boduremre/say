<?php defined('BASEPATH') or exit('No direct script access allowed');

class Crud_model extends CI_Model
{
    public string $table_name;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $where
     * @param string $order
     * @return mixed
     */
    public function get(array $where = array(), string $order = "id ASC"): mixed
    {
        return $this->db->where($where)->order_by($order)->get($this->table_name)->row();
    }

    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @param int $limit
     * @return array|object
     */
    public function all(array $where = array(), string $order = "id ASC", string $select = "*", int $limit = 10000): array|object
    {
        $this->db->select($select);
        $this->db->from($this->table_name);

        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->order_by($order);
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * @param array $data
     * @return bool|int
     */
    public function create(array $data = array()): bool|int
    {
        $data = $this->security->xss_clean($data);
        if ($this->db->insert($this->table_name, $data)) {
            return $this->db->insert_id() ?: true;
        }

        return false;
    }

    /**
     * @param array $where
     * @return int
     */
    public function count(array $where = array()): int
    {
        if (!empty($where)) {
            $this->db->where($where);
        }

        return $this->db->count_all_results($this->table_name);
    }

    /**
     * @param array $data
     * @return bool|int
     */
    public function insert_batch(array $data = array()): bool|int
    {
        $data = $this->security->xss_clean($data);
        return $this->db->insert_batch($this->table_name, $data) ?: false;
    }

    /**
     * @param array $where
     * @param array $data
     * @return bool
     */
    public function update(array $where = array(), array $data = array()): bool
    {
        $data = $this->security->xss_clean($data);
        return $this->db->where($where)->update($this->table_name, $data);
    }

    /**
     * @param array $where
     * @return bool
     */
    public function delete(array $where = array()): bool
    {
        return $this->db->where($where)->delete($this->table_name);
    }

    /**
     * @return bool
     */
    public function truncate_table(): bool
    {
        return $this->db->truncate($this->table_name);
    }

    /**
     * @param string $table_name
     * @return void
     */
    public function set_table(string $table_name): void
    {
        $this->table_name = $table_name;
    }
}
