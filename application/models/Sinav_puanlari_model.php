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
        $this->db->where('status !=', 0); // "G" notunu hariç tut
        $this->db->where($where);
        return $this->db->get($this->table_name)->row()->puan ?? null;
    }

    public function get_median_puan(array $where = array()): mixed
    {
        $this->db->select("puan");
        $this->db->where("puan IS NOT NULL");
        $this->db->where("status != 0");
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
        $sql = "SELECT STDDEV(puan) as stddev FROM sinav_puanlari WHERE status != 0 AND sinav_id = " . $sinav_id;
        return $this->db->query($sql)->row()->stddev;
    }

    public function get_variance_puan(array $where = array()): float|int|null
    {
        $this->db->select("puan");
        $this->db->where("puan IS NOT NULL");
        $this->db->where("status != 0");
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

    public function determine_exam_difficulty_based_on_variance($variance): string
    {
        if ($variance < 5) {
            return "SINAV KOLAY/ORTA"; // Kolay ya da orta seviyede bir sınav
        } elseif ($variance >= 5 && $variance <= 10) {
            return "SINAV ORTA ZOR"; // Orta zorlukta bir sınav
        } else {
            return "SINAV ÇOK ZOR"; // Zor bir sınav
        }
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
                WHERE puan IS NOT NULL AND status != 0 AND sinav_id= $sinav_id
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
                "status !=" => 0
            )
        );

        if ($toplam_ogrenci == 0)
            return 0;

        // Eşik değeri geçen öğrenci sayısını al
        $basarili_ogrenci = $this->count(
            array(
                "sinav_id" => $sinav_id,
                "puan >=" => $esik_deger,
                "status !=" => 0
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
        $this->db->select('COUNT(sinav_puanlari.id) as ogrenci_sayisi');
        $this->db->select_max('sinav_puanlari.puan', 'max_puan');
        $this->db->select_min('sinav_puanlari.puan', 'min_puan');
        $this->db->select_avg('sinav_puanlari.puan', 'avg_puan');         // öğrenci sayıları gelecek
        $this->db->join('okullar', 'sinav_puanlari.kurum_kodu = okullar.kurum_kodu');
        $this->db->where($where);
        $this->db->where('status !=', 0); // "G" notunu hariç tut
        $this->db->order_by($order_by);
        $this->db->group_by('sinav_puanlari.kurum_kodu'); // "G" notunu hariç tut

        return $this->db->get($this->table_name)->result_array();
    }

    /**
     * @param int $sinav_id
     * @return int
     */
    public function get_ranj(int $sinav_id): int
    {
        // En yüksek ve en düşük puanı al
        $this->db->select_max('puan', 'max_puan');
        $this->db->select_min('puan', 'min_puan');
        $this->db->where('sinav_id', $sinav_id);
        $this->db->where('status !=', 0); // Geçersiz notları dahil etme
        $query = $this->db->get('sinav_puanlari')->row_array();

        if (!$query || empty($query['max_puan']) || empty($query['min_puan'])) {
            return 0; // Veri yoksa 0 döndür
        }

        // Ranj = Maksimum Puan - Minimum Puan
        return (int) $query['max_puan'] - (int) $query['min_puan'];
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function get_ilce_ortalama(array $where = array()): mixed
    {
        $query = $this->db->query(
            "SELECT d.DistrictID, d.DistrictName AS ilce_adi, AVG(sp.puan) AS ilce_ortalama" . "
                    FROM sinav_puanlari sp
                    JOIN okullar o ON sp.kurum_kodu = o.kurum_kodu
                    JOIN districts d ON o.ILCE_ID = d.DistrictID
                    WHERE sp.sinav_id = ?
                    GROUP BY d.DistrictID, d.DistrictName", $where);

        return $query->result_array();
    }

    public function get_ilce_ogr_say(array $where = array()): mixed
    {
        $query = $this->db->query(
            "SELECT d.DistrictID, d.DistrictName AS ilce_adi, count(sp.puan) AS ogr_say" . "
                    FROM sinav_puanlari sp
                    JOIN okullar o ON sp.kurum_kodu = o.kurum_kodu
                    JOIN districts d ON o.ILCE_ID = d.DistrictID
                    WHERE sp.sinav_id = ?
                    GROUP BY d.DistrictID, d.DistrictName", $where);

        return $query->result_array();
    }

    /**
     * Verilen veri kümesi için çarpıklık hesaplama fonksiyonu
     * @param int $sinav_id
     * @return float|object|int
     */
    public function calculate_skewness(int $sinav_id): float|object|int
    {
        // Veritabanından sınavın puanlarını al
        $this->db->select("puan");
        $this->db->from($this->table_name);
        $this->db->where(array(
            "sinav_id" => $sinav_id,
            "status !=" => 0
        ));

        $data = $this->db->get()->result_array(); // Puanları alıyoruz

        // Eğer veri yoksa çarpıklık hesaplaması yapamayız
        if (empty($data)) {
            return 0;
        }

        $n = count($data); // Veri sayısını alıyoruz

        if ($n < 3) {
            return 0; // Çarpıklık için yeterli veri yok
        }

        // Verileri 'puan' anahtarına göre ayıklıyoruz
        $puanlar = array_column($data, 'puan');

        // Ortalama ve standart sapmayı hesapla
        $mean = array_sum($puanlar) / $n;
        $variance = 0;
        foreach ($puanlar as $value) {
            $variance += pow($value - $mean, 2);
        }
        $std_dev = sqrt($variance / $n);

        // Çarpıklık hesaplama
        $skewness = 0;
        foreach ($puanlar as $value) {
            $skewness += pow(($value - $mean) / $std_dev, 3);
        }

        // Çarpıklık değeri
        $skewness *= $n / (($n - 1) * ($n - 2));

        return $skewness;
    }


    // Çarpıklık değerine göre yorum yapacak fonksiyon
    public function interpret_skewness($skewness): string
    {
        if ($skewness > 1) {
            return 'Dağılım sağa çarpık (long tail right)';
        } elseif ($skewness < -1) {
            return 'Dağılım sola çarpık (long tail left)';
        } elseif ($skewness >= -1 && $skewness <= 1) {
            return 'Dağılım simetrik';
        } else {
            return 'Çarpıklık değeri hesaplanamadı';
        }
    }

    /**
     * Çarpıklık değerine göre sınavın zorluk derecesini belirleme fonksiyonu
     * @param $skewness
     * @return string
     */
    public function determine_exam_difficulty($skewness): string
    {
        // Eğer çarpıklık değeri boş veya 0'dan küçükse boş döndür
        if ($skewness === "") {
            return "";
        }

        // Çarpıklık değerine göre zorluk derecesi belirleme
        if ($skewness <= 0) {
            return "Sınav Çok Kolay";
        } elseif ($skewness < 0.1) {
            return "Sınav Kolay ";
        } elseif ($skewness <= 0.25) {
            return "Sınav Zor";
        } else {
            return "Sınav Çok Zor";
        }
    }

    public function determine_exam_difficultyy($variance, $skewness): string
    {
        // Varyansa dayalı zorluk derecesi
        if ($variance > 200) {
            $difficulty = "Sınav Çok Zor";
        } elseif ($variance > 100) {
            $difficulty = "Sınav Orta Zor";
        } else {
            $difficulty = "Sınav Kolay";
        }

        // Çarpıklıkla zorluk yorumunu entegre et
        if ($skewness > 0.5) {
            $difficulty = "Sınav Kolay"; // Sağ çarpık = kolay
        } elseif ($skewness < -0.5) {
            $difficulty = "Sınav Zor"; // Sol çarpık = zor
        }

        return $difficulty;
    }

    /**
     * Pearson Korelasyonu hesaplamak için örnek PHP fonksiyonu
     * @param $scores1
     * @param $scores2
     * @return float|int|string
     */
    // Pearson Korelasyonunu hesaplama fonksiyonu
    public function pearson_correlation($scores1, $scores2): float|int|string
    {
        $n = count($scores1);

        // Eğer veri setleri farklı uzunlukta ise, hata döndür
        if ($n != count($scores2)) {
            return 'Veri setleri farklı uzunlukta!';
        }

        // Toplamları ve karelerini hesapla
        $sum_x = array_sum($scores1);
        $sum_y = array_sum($scores2);

        $sum_x_squared = array_sum(array_map(function($x) { return $x * $x; }, $scores1));
        $sum_y_squared = array_sum(array_map(function($y) { return $y * $y; }, $scores2));

        // Çarpımları topla
        $sum_xy = array_sum(array_map(function($x, $y) { return $x * $y; }, $scores1, $scores2));

        // Pearson korelasyonunu hesapla
        $numerator = $sum_xy - (($sum_x * $sum_y) / $n);
        $denominator = sqrt(($sum_x_squared - ($sum_x * $sum_x) / $n) * ($sum_y_squared - ($sum_y * $sum_y) / $n));

        // Eğer payda sıfırsa, korelasyon sıfırdır
        if ($denominator == 0) {
            return 0;
        }

        return $numerator / $denominator;
    }

    // Korelasyon yorumlama fonksiyonu
    public function interpret_correlation($correlation): string
    {
        if ($correlation >= 0.9) {
            return "Çok yüksek bir ilişki var.";
        } elseif ($correlation >= 0.7) {
            return "Yüksek bir ilişki var.";
        } elseif ($correlation >= 0.5) {
            return "Orta seviyede bir ilişki var.";
        } elseif ($correlation >= 0.3) {
            return "Düşük bir ilişki var.";
        } else {
            return "Çok düşük bir ilişki var.";
        }
    }

    // Kimya ve Coğrafya sınavları arasındaki korelasyonu hesaplayıp yorum yapma
    public function get_correlation_and_interpretation($lesson1_scores, $lesson2_scores): array
    {
        $correlation = $this->pearson_correlation($lesson1_scores, $lesson2_scores);

        // Korelasyon değerini yorumla
        $interpretation = $this->interpret_correlation($correlation);

        return [
            'correlation' => $correlation,
            'interpretation' => $interpretation
        ];
    }
}
