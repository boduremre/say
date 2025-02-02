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
    public function all(array $where = array(), string $order = "created_at DESC", string $select = "sinavlar.*, siniflar.sinif_adi"): object|array
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->join('siniflar', 'siniflar.sinif_id = sinavlar.sinif_id');
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

    public function get(array $where = array(), string $select = "sinavlar.*, dersler.ders_id, dersler.ders_adi, siniflar.sinif_adi"): mixed
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->join('dersler', 'dersler.ders_id = sinavlar.ders_id');
        $this->db->join('siniflar', 'siniflar.sinif_id = sinavlar.sinif_id');
        $this->db->where($where);
        return $this->db->get()->row();
    }

    public function get_cevap_anahtari($where = array())
    {
        $this->db->select('sinavlar.cevap_anahtari');
        $this->db->from($this->table_name);
        $this->db->where($where);
        return $this->db->get()->row()->cevap_anahtari;
    }

    public function get_soru_sayisi($where = array())
    {
        $this->db->select('sinavlar.soru_sayisi');
        $this->db->from($this->table_name);
        $this->db->where($where);
        return $this->db->get()->row()->soru_sayisi;
    }

    public function get_all(array $where = array(), string $order = "created_at DESC", string $select = "sinavlar.*, siniflar.sinif_adi"): object|array
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->join('siniflar', 'siniflar.sinif_id = sinavlar.sinif_id');
        $this->db->order_by($order);
        return $this->db->get()->result();
    }

    public function get_all_w($where = array(), $order = "id DESC")
    {
        return $this->db->where($where)->order_by($order)->get($this->table_name)->result();
    }

    public function get_all_byUserID($userID)
    {
        $this->db->select('*')->from($this->table_name)->join('users', 'users.id = sinavlar.userID');
        return $this->db->where($userID)->get()->result();
    }

    public function getBysinavlarKodu($sinavlarKodu)
    {
        $this->db->select('sinavlar.*,dersler.*')->from($this->table_name)->join('dersler', 'dersler.id = sinavlar.dersID');
        return $this->db->where(array('sinavlar_kodu' => $sinavlarKodu))->get()->row();
    }

    public function add($data = array()): array
    {
        $result = $this->db->insert($this->table_name, $data);

        if ($result) {
            return array('result' => true, 'lastID' => $this->db->insert_id());
        } else {
            return array('result' => false, 'lastID' => 0);
        }
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

    public function delete(array $where = array())
    {
        return $this->db->where($where)->delete($this->table_name);
    }

    public function sendupdate($dogrulama_kodu, $data = array())
    {
        //print_r($data);
        return $this->db->update('sinavlar', $data, array('dogrulama_kodu' => $dogrulama_kodu));
    }
}
