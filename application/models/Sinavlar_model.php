<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model sınıfı: Sinavlar_model
 *
 * @property CI_DB_query_builder $db
 */
class Sinavlar_model extends CI_Model
{
    public string $table_name = "sinavlar";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @return object|array
     */
    public function all(array $where = array(), string $order = "sinavlar.created_at DESC", string $select = "sinavlar.*, siniflar.sinif_adi, 
    IFNULL(SUM(CASE WHEN sp.status = 1 AND sp.puan != 0 THEN 1 ELSE 0 END), 0) as ogrenci_sayisi, 
    IFNULL(AVG(CASE WHEN sp.status = 1 AND sp.puan != 0 THEN sp.puan ELSE NULL END), 0) as ortalama_puan"): object|array
    {
        $this->db->select($select, false); // SQL'in değiştirilmesini engellemek için FALSE kullanıyoruz
        $this->db->from($this->table_name);
        $this->db->join('siniflar', 'siniflar.sinif_id = sinavlar.sinif_id', 'left');
        $this->db->join("sinav_puanlari as sp", "sinavlar.id = sp.sinav_id", "left"); // LEFT JOIN ile birleştiriyoruz
        $this->db->group_by("sinavlar.id"); // Her sınav için toplam öğrenci sayısını hesaplıyoruz
        $this->db->where($where);
        $this->db->order_by($order);

        return $this->db->get()->result();
    }

    /**
     * @param array $data
     * @return bool|int
     */
    public function create(array $data = array()): bool|int
    {
        if ($this->db->insert($this->table_name, $data)) {
            return $this->db->insert_id() ?: true;
        }

        return false;
    }

    /**
     * @param array $where
     * @param string $select
     * @return mixed
     */
    public function get(array $where = array(), string $select = "sinavlar.*, dersler.ders_id, dersler.ders_adi, siniflar.sinif_adi, siniflar.sinif_seviyesi"): mixed
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->join('dersler', 'dersler.ders_id = sinavlar.ders_id');
        $this->db->join('siniflar', 'siniflar.sinif_id = sinavlar.sinif_id');
        $this->db->where($where);
        return $this->db->get()->row();
    }

    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @return object|array
     */
    public function get_all(array $where = array(), string $order = "created_at DESC", string $select = "sinavlar.*, siniflar.sinif_adi, COUNT(sp.id) as ogrenci_sayisi"): object|array
    {
        $this->db->select($select);
        $this->db->select_avg('sp.puan', 'avg_puan');
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->join('siniflar', 'siniflar.sinif_id = sinavlar.sinif_id');
        $this->db->join("sinav_puanlari as sp", "sinavlar.id = sp.sinav_id", "left"); // LEFT JOIN ile birleştiriyoruz
        $this->db->group_by("sinavlar.id");
        $this->db->order_by($order);
        return $this->db->get()->result();
    }

    /**
     * @param array $where
     * @param array $data
     * @return bool
     */
    public function update(array $where = array(), array $data = array()): bool
    {
        return $this->db->update($this->table_name, $data, $where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function delete(array $where = array()): mixed
    {
        return $this->db->where($where)->delete($this->table_name);
    }
}
