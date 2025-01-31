<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sinav_puanlari_model extends CI_Model
{
    public string $table_name = "sinav_puanlari";

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

    /**
     * Sınav puanları tablosundaki en yüksek puanı getirir.
     *
     * @return int|null En düşük puan veya hiç kayıt yoksa null
     */
    public function get_min_puan(array $where = array()): ?int
    {
        $this->db->select_min('puan');
        $this->db->where($where);
        $this->db->where('puan !=', 'G'); // "G" notunu hariç tut
        return $this->db->get($this->table_name)->row()->puan ?? null;
    }

    /**
     * Sınav puanları tablosundaki en yüksek puanı getirir.
     *
     * @return int|null En yüksek puan veya hiç kayıt yoksa null
     */
    public function get_max_puan(array $where = array()): ?int
    {
        $this->db->select_max('puan');
        $this->db->where('puan !=', 'G'); // "G" notunu hariç tut
        $this->db->where($where);
        return $this->db->get($this->table_name)->row()->puan ?? null;
    }

    /**
     * Sınav puanları tablosundaki puanların ortalamasını getirir.
     *
     * @return float|null Ortalama puan veya hiç kayıt yoksa null
     */
    public function get_avg_puan(array $where = array()): ?float
    {
        $this->db->select_avg('puan');
        $this->db->where('puan !=', 'G'); // "G" notunu hariç tut
        $this->db->where($where);
        return $this->db->get($this->table_name)->row()->puan ?? null;
    }

    /**
     * "G" notu hariç, puanların standart sapmasını hesaplar.
     *
     * @return float|null Standart sapma veya hiç geçerli kayıt yoksa null
     */
    public function get_stddev_puan($sinav_id): ?float
    {
        $sql = "SELECT STDDEV(puan) as stddev FROM sinav_puanlari WHERE puan != 'G' AND sinav_id = ".$sinav_id;
        return $this->db->query($sql)->row()->stddev;
    }

    /**
     * Belirli bir sınav için ("G" notu hariç) puanların standart sapmasını kurum koduna göre gruplandırarak hesaplar.
     *
     * @param int $sinav_id Sınav ID'si
     * @return array Standart sapma değerlerini içeren dizi
     */
    public function get_stddev_puan_by_kurum($sinav_id): array
    {
        $query = $this->db->query("SELECT kurum_kodu, STDDEV(puan) as stddev FROM sinav_puanlari WHERE puan != 'G' AND sinav_id = ? GROUP BY kurum_kodu", array($sinav_id));

        return $query->result_array(); // Birden fazla sonuç döneceği için result_array() kullanıyoruz
    }


    /**
     * @param array $where
     * @return array|object
     */
    public function get_min_puan_kurum(array $where = array()): array|object
    {
        $this->db->select('kurum_kodu');
        $this->db->select_min('puan');
        $this->db->where($where);
        $this->db->where('puan !=', 'G'); // "G" notunu hariç tut
        $this->db->group_by('kurum_kodu'); // "G" notunu hariç tut

        return $this->db->get($this->table_name)->result_array();
    }

    /**
     * @param array $where
     * @return array|object
     */
    public function get_min_max_avg_puan_kurum(array $where = array(), string $order_by = "avg_puan asc"): array|object
    {
        $this->db->select('kurum_kodu');
        $this->db->select_max('puan', 'max_puan');
        $this->db->select_min('puan', 'min_puan');
        $this->db->select_avg('puan','avg_puan');
        $this->db->where($where);
        $this->db->where('puan !=', 'G'); // "G" notunu hariç tut
        $this->db->order_by($order_by); // "G" notunu hariç tut
        $this->db->group_by('kurum_kodu'); // "G" notunu hariç tut

        return $this->db->get($this->table_name)->result_array();
    }

    /**
     * Sınav puanları tablosundaki puanların ortalamasını getirir.
     *
     * @return float|null Ortalama puan veya hiç kayıt yoksa null
     */
    public function get_avg_puan_kurum(array $where = array()): ?float
    {
        $this->db->select_avg('puan');
        $this->db->where('puan !=', 'G'); // "G" notunu hariç tut
        $this->db->where($where);
        return $this->db->get($this->table_name)->row()->puan ?? null;
    }



}
