<?php defined('BASEPATH') or exit('No direct script access allowed');

class Okullar_model extends CI_Model
{
    private string $table_name = "okullar";

    /**
     * @param array $where
     * @return mixed
     */
    public function get(array $where = array()): mixed
    {
        $this->db->select('okullar.id,okullar.kurum_kodu, okullar.kurum_adi, okullar.eposta, okullar.eposta2, okullar.web, okullar.telefon, okullar.adres, okullar.mudur, okullar.mudur_cep, okullar.mudur_yrd, okullar.mudur_yrd_cep, okullar.il_id, okullar.durum, okullar.ilce_id, cities.CityName as il_adi, districts.DistrictName as ilce_adi');
        $this->db->from('okullar');
        $this->db->join('cities', 'okullar.IL_ID = cities.CityID');
        $this->db->join('districts', 'okullar.ILCE_ID = districts.DistrictID');
        $this->db->order_by('ilce_adi', 'ASC');
        $this->db->order_by('kurum_kodu', 'ASC');
        $this->db->where($where);
        return $this->db->get()->row();
    }

    /**
     * @return mixed
     */
    public function all(): mixed
    {
        $this->db->select('okullar.id, okullar.kurum_adi, okullar.kurum_kodu, okullar.kurum_turu, okullar.durum, districts.DistrictName as ilce_adi');
        $this->db->from('okullar');
        $this->db->join('districts', 'okullar.ILCE_ID = districts.DistrictID');
        $this->db->order_by('ilce_adi', 'ASC');
        $this->db->order_by('kurum_kodu', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * @param array $where
     * @param string $order
     * @param string $select
     * @return mixed
     */
    public function select_list(array $where = array(), string $order = "districts.DistrictName, okullar.kurum_adi ASC", string $select = "okullar.kurum_kodu, okullar.kurum_adi, districts.DistrictName as ilce_adi"): mixed
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->join('districts', 'okullar.ILCE_ID = districts.DistrictID');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get()->result();
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data = array()): mixed
    {
        return $this->db->update($this->table_name, $data, array('okullar.ID' => $id));
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
