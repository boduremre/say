<?php defined('BASEPATH') or exit('No direct script access allowed');

class Siniflar_model extends CI_Model
{
    private string $table_name = "siniflar";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $where
     * @return array|mixed|object|null
     */
    public function get(array $where = array()): mixed
    {
        return $this->db->where($where)->get($this->table_name)->row();
    }

    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @return object|array
     */
    public function all(array $where = array(), string $order = "siniflar.sinif_id ASC", string $select = "siniflar.*"): object|array
    {

        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get()->result();
    }


    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @return object|array
     */
    public function select_list(array $where = array(), string $order = "siniflar.sinif_id ASC", string $select = 'siniflar.sinif_id, siniflar.sinif_adi'): object|array
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get()->result();
    }

    /**
     * @param array $where
     * @return int
     */
    public function count(array $where = array()): int
    {
        return $this->db->where($where)->from($this->table_name)->count_all_results();
    }

    /**
     * @param array $data
     * @return array
     */
    public function add(array $data = array()): array
    {
        $result = $this->db->insert($this->table_name, $data);

        if ($result) {
            return array('result' => true, 'last_id' => $this->db->insert_id());
        } else {
            return array('result' => false, 'last_id' => 0);
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data = array()): bool
    {
        return $this->db->insert($this->table_name, $data);
    }

    /**
     * @param array $data
     * @return bool|int
     */
    public function insert_batch(array $data = array()): bool|int
    {
        return $this->db->insert_batch($this->table_name, $data);
    }

    /**
     * @param array $where
     * @param array $data
     * @return bool
     */
    public function update(array $where = array(), array $data = array()): bool
    {
        return $this->db->where($where)->update($this->table_name, $data);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function delete(array $where = array()): mixed
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
     * @param string $sql
     * @return mixed
     */
    public function execute_sql(string $sql = "SELECT siniflar.* FROM siniflar"): mixed
    {
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}