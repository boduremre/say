<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dersler_model extends CI_Model
{
   public string $table_name = "dersler";

   public function __construct()
   {
      parent::__construct();
   }

    /**
     * @param array $where
     * @return mixed
     */
    public function get(array $where = array()): mixed
    {
      return $this->db->where($where)->get($this->table_name)->row();
   }

   /**
    * @param array $where
    * @param string $order
    * @return object|array
    */
   public function all(array $where = array(), string $order = "dersler.ders_id ASC", $select = "dersler.*"): object|array
   {
      $this->db->select($select);
      $this->db->from($this->table_name);
      $this->db->where($where);
      $this->db->order_by($order);
      return $this->db->get()->result();
   }

   public function get_all_j()
   {
      $this->db->select('*')->from($this->table_name)->join('users', 'users.id = sorular.userID');
      return $this->db->get()->result();
   }

   public function get_all(array $where = array(), string $order = "ders_adi ASC"): object|array
   {
      return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
   }

   public function add($data = array())
   {
      return $this->db->insert($this->table_name, $data);
   }

   public function update($where = array(), $data = array())
   {
      return $this->db->where($where)->update($this->table_name, $data);
   }

   /**
    * @param array $where
    * @return int
    */
   public function count(array $where = array()): int
   {
      return $this->db->where($where)->from($this->table_name)->count_all_results();
   }

   public function delete($where = array())
   {
      return $this->db->where($where)->delete($this->table_name);
   }


    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @return object|array
     */
    public function select_list(array $where = array(), string $order = "dersler.ders_adi ASC", string $select = 'dersler.ders_id, dersler.ders_adi'): object|array
   {
      $this->db->select($select);
      $this->db->from($this->table_name);
      $this->db->where($where);
      $this->db->order_by($order);
      return $this->db->get()->result();
   }
}
