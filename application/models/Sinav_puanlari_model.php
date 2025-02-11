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
    public function all(array $where = array(), string $order = "sinav_puanlari.id ASC", string $select = "sinav_puanlari.*, okullar.KURUM_ADI", int $limit = 10000): array|object
    {
        $this->db->select($select);
        $this->db->from($this->table_name);
        $this->db->join('okullar', 'sinav_puanlari.kurum_kodu = okullar.kurum_kodu');
        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->order_by($order);
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function get_all(array $where = array()): mixed
    {
        // Veritabanından sınavın puanlarını al
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where($where);
        return $this->db->get()->result_array();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function get_puanlar(array $where = array()): mixed
    {
        // Veritabanından sınavın puanlarını al
        $this->db->select("sinav_puanlari.puan");
        $this->db->from($this->table_name);
        $this->db->where($where);
        return $this->db->get()->result_array();
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
        $this->db->where('puan !=', 0); // "G" notunu hariç tut
        $this->db->where('status !=', 0); // "G" notunu hariç tut
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
        $this->db->where('puan !=', 0);
        $this->db->where('status !=', 0); // "G" notunu hariç tut
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
        $this->db->where('puan !=', 0);
        $this->db->where('status !=', 0); // "G" notunu hariç tut
        $this->db->where($where);
        return $this->db->get($this->table_name)->row()->puan ?? null;
    }

    public function get_median_puan(array $where = array()): mixed
    {
        $this->db->select("puan");
        $this->db->where("puan IS NOT NULL");
        $this->db->where("status != 0");
        $this->db->where("puan != 0");
        $this->db->where($where);
        $this->db->order_by("puan", "ASC");
        $query = $this->db->get("sinav_puanlari");

        $puanlar = array_column($query->result_array(), "puan");

        $count = count($puanlar);
        if ($count == 0) return null;

        $middle = floor($count / 2);
        if ($count % 2) {
            return $puanlar[$middle]; // Tek sayıysa direkt ortadaki
        } else {
            return ($puanlar[$middle - 1] + $puanlar[$middle]) / 2; // Çift sayıysa ortalamaları
        }
    }

    /**
     * Girmeyen öğrenciler hariç puanların standart sapmasını hesaplar.
     * @param int $sinav_id
     * @return float|null Standart sapma veya hiç geçerli kayıt yoksa null
     */
    public function get_stddev_puan(int $sinav_id): ?float
    {
        $sql = "SELECT STDDEV(puan) as stddev FROM sinav_puanlari WHERE puan != 0 AND status != 0 AND sinav_id = " . $sinav_id;
        return $this->db->query($sql)->row()->stddev;
    }

    public function get_variance_puan(array $where = array()): float|int|null
    {
        $this->db->select("puan");
        $this->db->where("puan IS NOT NULL");
        $this->db->where("status != 0");
        $this->db->where("puan != 0");
        $this->db->where($where);
        $query = $this->db->get("sinav_puanlari");

        $puanlar = array_column($query->result_array(), "puan");

        $count = count($puanlar);
        if ($count < 2) return null;

        $mean = array_sum($puanlar) / $count;
        $sum = 0;

        foreach ($puanlar as $puan) {
            $sum += pow($puan - $mean, 2);
        }

        return $sum / ($count - 1); // Örneklem varyansı
    }

    /**
     * @param int $sinav_id
     * @return mixed
     */
    public function get_mode_puan(int $sinav_id): mixed
    {
        $query = $this->db->query("
                SELECT puan, COUNT(*) as tekrar_sayisi 
                FROM sinav_puanlari 
                WHERE puan IS NOT NULL AND status != 0 AND puan != 0 AND sinav_id= $sinav_id
                GROUP BY puan 
                ORDER BY tekrar_sayisi DESC 
                LIMIT 1
        ");

        return $query->row(); // En sık tekrar eden puanı döndürür
    }

    public function get_basari_orani(int $sinav_id, int $esik_deger = 50): float
    {
        // Toplam öğrenci sayısını al
        $toplam_ogrenci = $this->count(
            array(
                "sinav_id" => $sinav_id,
                "status !=" => 0,
                "puan !=" => 0
            )
        );

        if ($toplam_ogrenci == 0)
            return 0;

        // Eşik değeri geçen öğrenci sayısını al
        $basarili_ogrenci = $this->count(
            array(
                "sinav_id" => $sinav_id,
                "puan >=" => $esik_deger,
                "status !=" => 0,
                "puan !=" => 0
            )
        );

        // Başarı oranı hesaplama
        return round(($basarili_ogrenci / $toplam_ogrenci) * 100, 2); // Yüzde formatında döndür
    }

    /**
     * @param array $where
     * @param string $order_by
     * @return array|object
     */
    public function get_min_max_avg_puan_kurum(array $where = array(), string $order_by = "avg_puan asc"): array|object
    {
        $this->db->select('sinav_puanlari.kurum_kodu, okullar.KURUM_ADI');
        $this->db->select("districts.DistrictName AS ilce_adi");
        $this->db->select('COUNT(sinav_puanlari.id) as ogrenci_sayisi');
        $this->db->select_max('sinav_puanlari.puan', 'max_puan');
        $this->db->select_min('sinav_puanlari.puan', 'min_puan');
        $this->db->select_avg('sinav_puanlari.puan', 'avg_puan');
        $this->db->join('okullar', 'sinav_puanlari.kurum_kodu = okullar.kurum_kodu');
        $this->db->join('districts', 'okullar.ILCE_ID = districts.DistrictID');
        $this->db->where($where);
        $this->db->where('status !=', 0); // "G" notunu hariç tut
        $this->db->where('puan !=', 0); // "G" notunu hariç tut
        $this->db->order_by($order_by);
        $this->db->group_by('sinav_puanlari.kurum_kodu'); // "G" notunu hariç tut

        return $this->db->get($this->table_name)->result_array();
    }

    /**
     * @param array $where
     * @param string $order_by
     * @return array|object
     */
    public function get_min_max_avg_puan_proje_okullari(array $where = array(), string $order_by = "avg_puan asc"): array|object
    {
        $this->db->select('sinav_puanlari.kurum_kodu, okullar.KURUM_ADI');
        $this->db->select("districts.DistrictName AS ilce_adi");
        $this->db->select('COUNT(sinav_puanlari.id) as ogrenci_sayisi');
        $this->db->select_max('sinav_puanlari.puan', 'max_puan');
        $this->db->select_min('sinav_puanlari.puan', 'min_puan');
        $this->db->select_avg('sinav_puanlari.puan', 'avg_puan');
        $this->db->join('okullar', 'sinav_puanlari.kurum_kodu = okullar.kurum_kodu');
        $this->db->join('districts', 'okullar.ILCE_ID = districts.DistrictID');
        $this->db->where($where);
        $this->db->where('okullar.proje_okulu', 1); // Proje okulu olanları filtrele
        $this->db->where('status !=', 0); // "G" notunu hariç tut
        $this->db->where('puan !=', 0); // "G" notunu hariç tut
        $this->db->order_by($order_by);
        $this->db->group_by('sinav_puanlari.kurum_kodu'); // Gruplama

        return $this->db->get($this->table_name)->result_array();
    }


    /**
     * @param int $sinav_id
     * @return int
     */
    public function get_ranj(int $sinav_id): int
    {
        $this->db->select_max('puan', 'max_puan');
        $this->db->select_min('puan', 'min_puan');
        $this->db->where('sinav_id', $sinav_id);
        $this->db->where('status !=', 0);
        $this->db->where('puan !=', 0);
        $query = $this->db->get('sinav_puanlari')->row();

        if (!$query || is_null($query->max_puan) || is_null($query->min_puan)) {
            return 0;
        }

        // String olan değerleri integer'a çevirerek işlem yap
        return (int)$query->max_puan - (int)$query->min_puan;
    }

    /**
     * @param array $where
     * @param string $order_by
     * @return mixed
     */
    public function get_ilce_ortalama(array $where = array(), string $order_by = "ORDER BY ilce_ortalama ASC"): mixed
    {
        $query = $this->db->query(
            "SELECT d.DistrictID, d.DistrictName AS ilce_adi, AVG(sp.puan) AS ilce_ortalama, MIN(sp.puan) as min_puan, MAX(sp.puan) as max_puan, COUNT(sp.puan) AS ogr_sayisi" . "
                    FROM sinav_puanlari sp
                    JOIN okullar o ON sp.kurum_kodu = o.kurum_kodu
                    JOIN districts d ON o.ILCE_ID = d.DistrictID
                    WHERE sp.status = 1 AND sp.puan!=0 AND sp.sinav_id = ? 
                    GROUP BY d.DistrictID, d.DistrictName " . $order_by, $where);

        return $query->result_array();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function get_ilce_ogr_say(array $where = array()): mixed
    {
        $this->db->select("
        d.DistrictID, 
        d.DistrictName AS ilce_adi, 
        COUNT(sp.id) AS ogr_say,
        COUNT(CASE WHEN sp.puan != 0 AND sp.status != 0 THEN 1 END) AS katilan_ogr_say,
        (COUNT(puan) - COUNT(CASE WHEN sp.puan != 0 AND sp.status != 0 THEN 1 END)) AS fark");
        $this->db->from("sinav_puanlari sp");
        $this->db->join("okullar o", "sp.kurum_kodu = o.kurum_kodu");
        $this->db->join("districts d", "o.ILCE_ID = d.DistrictID");
        $this->db->where($where);
        $this->db->group_by(["d.DistrictID", "d.DistrictName"]);

        return $this->db->get()->result_array();
    }

    /**
     * @param array $where
     * @param string $order_by
     * @return mixed
     */
    public function get_genel_mudurluk_ortalama(array $where = array(), string $order_by = "ORDER BY sp.puan ASC"): mixed
    {
        $query = $this->db->query(
            "SELECT AVG(sp.puan) AS genel_mudurluk_ortalama, o.GENEL_MUDURLUK as genel_mudurluk_adi, MIN(sp.puan) as min_puan, MAX(sp.puan) as max_puan, COUNT(sp.puan) AS ogr_sayisi" . "
                    FROM sinav_puanlari sp
                    JOIN okullar o ON sp.kurum_kodu = o.kurum_kodu
                    WHERE sp.puan != 0 AND sp.status = 1 AND sp.sinav_id = ? 
                    GROUP BY o.GENEL_MUDURLUK " . $order_by, $where);

        return $query->result_array();
    }

    /**
     * @param array $where
     * @return array
     */
    public function get_puan_dagilimi(array $where = array()): array
    {
        $this->db->select("CASE 
            WHEN puan BETWEEN 0 AND 49 THEN '0 - 49 ARASI'
            WHEN puan BETWEEN 50 AND 59 THEN '50 - 59 ARASI'
            WHEN puan BETWEEN 60 AND 69 THEN '60 - 69 ARASI'
            WHEN puan BETWEEN 70 AND 84 THEN '70 - 84 ARASI'
            WHEN puan BETWEEN 85 AND 100 THEN '85 - 100 ARASI'
            ELSE 'Diğer' END AS puan_araligi, COUNT(*) as ogrenci_sayisi");
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->group_by("puan_araligi");
        $this->db->order_by("puan_araligi", "desc");

        return $this->db->get()->result_array();
    }

    /**
     * @param array $where
     * @return array
     */
    public function get_puan_dagilimi_yeni(array $where = array()): array
    {
        $this->db->select("CASE 
            WHEN puan BETWEEN 0 AND 10 THEN '0 - 10 ARASI'
            WHEN puan BETWEEN 11 AND 20 THEN '11 - 20 ARASI'
            WHEN puan BETWEEN 21 AND 30 THEN '21 - 30 ARASI'
            WHEN puan BETWEEN 31 AND 40 THEN '31 - 40 ARASI'
            WHEN puan BETWEEN 41 AND 50 THEN '41 - 50 ARASI'
            WHEN puan BETWEEN 51 AND 60 THEN '51 - 60 ARASI'
            WHEN puan BETWEEN 61 AND 70 THEN '61 - 70 ARASI'
            WHEN puan BETWEEN 71 AND 80 THEN '71 - 80 ARASI'
            WHEN puan BETWEEN 81 AND 90 THEN '81 - 90 ARASI'
            WHEN puan BETWEEN 91 AND 100 THEN '91 - 100 ARASI'
            ELSE 'Diğer' END AS puan_araligi, COUNT(*) as ogrenci_sayisi");
        $this->db->from($this->table_name);
        $this->db->where($where);
        $this->db->group_by("puan_araligi");
        $this->db->order_by("puan_araligi", "asc");

        return $this->db->get()->result_array();
    }

    /**
     * @param string $order_by
     * @return array
     */
    public function get_all_exam_stats_per_school(string $order_by = "avg_puan asc"): array
    {
        $this->db->select('sinav_puanlari.kurum_kodu, okullar.KURUM_ADI');
        $this->db->select("sinav_puanlari.sinav_id");
        $this->db->select("districts.DistrictName AS ilce_adi");
        $this->db->select('COUNT(sinav_puanlari.id) as ogrenci_sayisi');
        $this->db->select_max('sinav_puanlari.puan', 'max_puan');
        $this->db->select_min('sinav_puanlari.puan', 'min_puan');
        $this->db->select_avg('sinav_puanlari.puan', 'avg_puan');
        $this->db->join('okullar', 'sinav_puanlari.kurum_kodu = okullar.kurum_kodu');
        $this->db->join('districts', 'okullar.ILCE_ID = districts.DistrictID');
        $this->db->where('sinav_puanlari.puan !=', 0); // Geçersiz puanları hariç tut
        $this->db->where('sinav_puanlari.status !=', 0); // Geçersiz durumları hariç tut
        $this->db->group_by(['sinav_puanlari.kurum_kodu', 'sinav_puanlari.sinav_id']); // Okul ve sınav bazında gruplama
        $this->db->order_by($order_by);

        return $this->db->get('sinav_puanlari')->result_array();
    }


}
