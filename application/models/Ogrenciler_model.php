<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ogrenciler_model extends CI_Model
{
    private string $table_name = "ogrenciler";

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
        $this->db->select('ogrenciler.id,ogrenciler.opaq,ogrenciler.ad,ogrenciler.soyad,ogrenciler.ogr_no,ogrenciler.sinif,ogrenciler.sinif_id,ogrenciler.sube,ogrenciler.sifre,ogrenciler.eposta,ogrenciler.telefon,ogrenciler.durum,ogrenciler.kayit_tarihi,ogrenciler.kurum_kodu,okullar.KURUM_ADI');
        $this->db->from($this->table_name);
        $this->db->join('okullar', 'ogrenciler.kurum_kodu = okullar.kurum_kodu');
        $this->db->where($where);

        return $this->db->get()->row();
    }

    /**
     * @return mixed
     */
    public function get_all(): mixed
    {
        $this->db->select('ogrenciler.id,ogrenciler.ad,ogrenciler.soyad,ogrenciler.ogr_no,ogrenciler.sinif,ogrenciler.sube,ogrenciler.sifre,ogrenciler.durum,ogrenciler.kayit_tarihi,ogrenciler.kurum_kodu,okullar.KURUM_ADI');
        $this->db->from($this->table_name);
        $this->db->join('okullar', 'okullar.KURUM_KODU = ogrenciler.kurum_kodu');
        $this->db->order_by('ogr_no ASC');
        return $this->db->get()->result();
    }

    /**
     * @param array $where
     * @param string $order
     * @return mixed
     */
    public function get_all_w(array $where = array(), string $order = "ogrenciler.id DESC"): mixed
    {
        return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
    }


    /**
     * @param array $where
     * @param string $select
     * @return mixed
     */
    public function all(array $where = array(), string $select = "ogrenciler.*"): mixed
    {
        $this->db->select($select)->from($this->table_name)->join('okullar', 'okullar.KURUM_KODU = ogrenciler.kurum_kodu');
        return $this->db->where($where)->get()->result();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data = array()): mixed
    {
        return $this->db->insert($this->table_name, $data);
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
     * @param string $sql
     * @return mixed
     */
    public function execute_sql(string $sql = "SELECT ogrenciler.* FROM ogrenciler"): mixed
    {
        return $this->db->query($sql);
    }
}
