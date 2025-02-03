<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sinavlar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //load models
        $this->load->model("sinavlar_model");
        $this->load->model("dersler_model");
        $this->load->model("siniflar_model");

        //load helper
        $this->load->helper("guid");

        $this->layout->title = "Sınavlar";
    }

    /**
     * @return void
     */
    public function index(): void
    {
        // sinavları getir
        $this->layout->data["sinavlar"] = $this->sinavlar_model->get_all();
        $this->layout->render();
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->layout->data["dersler"] = $this->dersler_model->all();
        $this->layout->data["siniflar"] = $this->siniflar_model->select_list();

        $this->layout->render();
    }

    /**
     * @return void
     */
    public function store(): void
    {
        is_post_request();

        $form_values = array(
            "sinav_adi" => $this->input->post("sinav_adi", TRUE),
            "aciklama" => $this->input->post("aciklama", TRUE),
            "ders_id" => $this->input->post("ders_id", TRUE),
            "sinif_id" => $this->input->post("sinif_id", TRUE),
            "yayin_durumu" => $this->input->post("yayin_durumu", TRUE),
            "dosya_adresi" => "",
            "soru_sayisi" => $this->input->post("soru_sayisi", TRUE),
            "secenek_sayisi" => 0,
            "dogrulama_kodu" => strtolower(GUID()),
            "baslangic_tarihi" => $this->input->post("baslangic_tarihi", TRUE),
            "bitis_tarihi" => $this->input->post("baslangic_tarihi", TRUE),
            "sure" => 40,
            "user_id" => $this->ion_auth->user()->row()->id,
            "sinav_kodu" => "SNV-" . rand(150, 999),
            "cevap_anahtari" => "",
        );

        $result = $this->sinavlar_model->create($form_values);
        _alert_message($result);
    }

    /**
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $this->layout->data["sinavlar"] = $this->sinavlar_model->get_all();
        $this->layout->data["sinav"] = $this->sinavlar_model->get(array('sinavlar.id' => $id));
        $this->layout->data["dersler"] = $this->dersler_model->get_all();
        $this->layout->data["siniflar"] = $this->siniflar_model->select_list();

        $this->layout->render();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        is_post_request();

        $form_values = array(
            "sinav_adi" => $this->input->post("sinav_adi", TRUE),
            "aciklama" => $this->input->post("aciklama", TRUE),
            "ders_id" => $this->input->post("ders_id", TRUE),
            "sinif_id" => $this->input->post("sinif_id", TRUE),
            "soru_sayisi" => $this->input->post("soru_sayisi", TRUE),
            "dogrulama_kodu" => $this->input->post("dogrulama_kodu", TRUE),
            "baslangic_tarihi" => $this->input->post("baslangic_tarihi", TRUE),
            "bitis_tarihi" => $this->input->post("baslangic_tarihi", TRUE),
            "user_id" => $this->ion_auth->user()->row()->id,
        );

        $dogrulama_kodu = $this->input->post("dogrulama_kodu", TRUE);
        $update = $this->sinavlar_model->update(array("dogrulama_kodu" => $dogrulama_kodu), $form_values);
        if ($update)
            swal("İşlem Başarılı", "Sınav başarıyla güncellendi!", "sinavlar");
        else
            swal("İşlem Başarısız", "Sınav güncellenirken hata meydana geldi!", "sinavlar", "error");
    }

    /**
     * @param string $dogrulama_kodu
     * @return void
     */
    public function delete(string $dogrulama_kodu): void
    {
        if (!empty($dogrulama_kodu)) {
            $delete = $this->sinavlar_model->delete(array('dogrulama_kodu' => $dogrulama_kodu));
            _alert_message($delete, site_url("sinavlar/index"), "Sınavınız başarıyla silindi!");
        }
    }

    /**
     * @desc Kaydedilen sınavın analiz edilmesini sağlar.
     * @param string $id
     * @return void
     */
    public function analyze(string $id): void
    {
        $this->layout->data["sinav"] = $this->sinavlar_model->get(array('sinavlar.id' => $id));

        $this->layout->render();
    }

    public function truncate_analyze(): void
    {
        is_post_request();

        $this->load->model('sinav_puanlari_model');

        $sinav_id = $this->input->post("sinav_id", TRUE);

        $delete = $this->sinav_puanlari_model->delete(array('sinav_id' => $sinav_id));
        if($delete){
            $form_values = array(
                "yayin_durumu" => 0,
            );

            $update = $this->sinavlar_model->update(array("id" => $sinav_id), $form_values);
            if ($update)
                swal("İşlem Başarılı", "Sınav analizi başarıyla sıfırlandı!", "sinavlar");
        }

        $this->layout->render();
    }

    /**
     * @desc Kaydedilen sınavın analiz edilmesini sağlar.
     * @param string $sinav_id
     * @return void
     */
    public function do_analyze(string $sinav_id): void
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $this->load->model('sinav_puanlari_model');

        //Merkezi Eğilim Ölçütleri (Ortalama, Medyan, Mod)
        //    Bu ölçütler, puanların genel dağılımını anlamamıza yardımcı olur.
        //
        //    Ortalama (Mean): Tüm puanların toplamının öğrenci sayısına bölünmesiyle elde edilir.
        //    Medyan (Median): Puanlar küçükten büyüğe sıralandığında tam ortadaki değerdir.
        //    Mod (Mode): En sık tekrar eden puandır.
        //
        //    Yorum:
        //      Ortalama yüksekse, genel başarı seviyesi yüksektir.
        //      Medyan, aşırı uç değerlerden etkilenmez ve genel başarı eğilimini daha iyi yansıtır.
        //      Mod, hangi puanın en fazla alındığını gösterir.

        //Yayılım Dağılım Ölçütleri
        //    Standart sapma yüksekse, öğrenciler arasındaki başarı farkı fazladır.
        //    Standart sapma düşükse, öğrencilerin başarı düzeyi birbirine yakındır.
        //    Çeyrekler, başarının belirli gruplara nasıl dağıldığını gösterir.

        //    3. Başarı Yüzdeleri ve Geçme-Kalma Analizi
        //    Öğrencilerin başarı seviyelerini belirli yüzdelik dilimlere ayırarak analiz edebiliriz.
        //
        //    Başarı Oranı: Belirli bir eşiğin (örneğin 50 puan) üzerinde olan öğrencilerin yüzdesi.
        //    Üst Yüzdelik Dilimler (Top %10, %25): En başarılı öğrencileri belirler.
        //    Alt Yüzdelik Dilimler (Bottom %10, %25): En düşük başarı gösteren öğrencileri belirler.
        //
        //    Yorum:
        //      Eğer üst yüzdelik dilimde çok az öğrenci varsa, başarılı öğrenci sayısı düşük olabilir.
        //      Alt yüzdelik dilimde çok fazla öğrenci varsa, başarı seviyesi düşük olabilir.
        $skewness = $this->sinav_puanlari_model->calculate_skewness($sinav_id);
        $variance = $this->sinav_puanlari_model->get_variance_puan(array("sinav_id" => $sinav_id));
        $puan_dagilimi = $this->sinav_puanlari_model->get_puan_dagilimi(array("sinav_id" => $sinav_id, "status !=" => 0));

        $this->layout->data["istatistikler"] = array(
            "sinav_bilgisi" => $this->sinavlar_model->get(array('sinavlar.id' => $sinav_id)),
            "toplam_ogrenci_sayisi" => $this->sinav_puanlari_model->count(array('sinav_id' => $sinav_id)),
            "katilan_ogrenci_sayisi" => $this->sinav_puanlari_model->count(array('sinav_id' => $sinav_id, "status" => 1)),
            "katilmayan_ogrenci_sayisi" => $this->sinav_puanlari_model->count(array('sinav_id' => $sinav_id, "status" => 0)),
            "basarili_ogrenci_sayisi" => $this->sinav_puanlari_model->count(array('sinav_id' => $sinav_id, "status" => 1, "puan>=" => 50)),
            "basarisiz_ogrenci_sayisi" => $this->sinav_puanlari_model->count(array('sinav_id' => $sinav_id, "status" => 1, "puan<" => 50)),
            "basari_orani" => $this->sinav_puanlari_model->get_basari_orani($sinav_id, 50),
            "min_puan" => $this->sinav_puanlari_model->get_min_puan(array('sinav_id' => $sinav_id)),
            "max_puan" => $this->sinav_puanlari_model->get_max_puan(array('sinav_id' => $sinav_id)),
            "ranj" => $this->sinav_puanlari_model->get_ranj($sinav_id),
            "avg_puan" => $this->sinav_puanlari_model->get_avg_puan(array('sinav_id' => $sinav_id)),
            "median_puan" => $this->sinav_puanlari_model->get_median_puan(array('sinav_id' => $sinav_id)),
            "puan_dagilimi" => $puan_dagilimi,
            "puan_dagilim_grafigi" => $this->draw_bar_chart($puan_dagilimi),
            "mode" => $this->sinav_puanlari_model->get_mode_puan($sinav_id),
            "standart_sapma" => $this->sinav_puanlari_model->get_stddev_puan($sinav_id),
            "varyans" => $variance,
            "determine_exam_difficulty_based_on_variance" => $this->sinav_puanlari_model->determine_exam_difficulty_based_on_variance($variance),
            "skewness" => $skewness,
            "interpret_skewness" => $this->sinav_puanlari_model->interpret_skewness($skewness),
            "skewness_determine_exam_difficulty" => $this->sinav_puanlari_model->determine_exam_difficulty($skewness),
            "skewness_graph_link" => $this->sinav_puanlari_model->plot_skewness_graph($sinav_id),
            "determine_exam_difficulty_variance_skewness" => $this->sinav_puanlari_model->determine_exam_difficultyy($variance, $skewness),
            "DİKKAT" => "Skewness ve Varyanstan; varyans genellikle sınav zorluğu ve öğrencilerin performansı hakkında daha kesin bir bilgi verir.",
            "puan_kurumlar" => $this->sinav_puanlari_model->get_min_max_avg_puan_kurum(array('sinav_id' => $sinav_id), "ilce_adi asc, KURUM_ADI asc"),
            "puan_kurumlar_sirali" => $this->sinav_puanlari_model->get_min_max_avg_puan_kurum(array('sinav_id' => $sinav_id), "avg_puan desc"),
            "puan_ilceler" => $this->sinav_puanlari_model->get_ilce_ortalama(array("sinav_id" => $sinav_id), "ORDER BY ilce_adi asc"),
            "puan_ilceler_sirali" => $this->sinav_puanlari_model->get_ilce_ortalama(array("sinav_id" => $sinav_id), "ORDER BY sp.puan DESC"),
            "ogr_say_ilceler" => $this->sinav_puanlari_model->get_ilce_ogr_say(array("sinav_id" => $sinav_id)),
            "genel_mudurluk_ortalama" => $this->sinav_puanlari_model->get_genel_mudurluk_ortalama(array("sinav_id" => $sinav_id)),
        );

        //download_json("istatistikler.json", $istatistikler);

        // Sınav durumunu Analiz Tamamlandı olarak güncelle
        $update = $this->sinavlar_model->update(
            array("sinavlar.id" => $sinav_id),
            array("sinavlar.yayin_durumu" => 1)
        );

        if($update){
            $this->layout->set_view("report");
            $this->layout->render();
        }
    }

    public function excel_upload(): void
    {
        // Gelen istek post isteği mi kontrol et
        is_post_request();

        // Kütüphane ve modelleri yükle
        $this->load->library('php_excel');
        $this->load->model('sinav_puanlari_model');

        $sinav_id = $this->input->post('sinav_id', TRUE);
        $result = false;

        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);

            $batch_data = []; // Tüm verileri bu dizide toplayacağız

            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; $row++) {
                    $ogr_no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $ogr_adi_soyadi = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $puan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $kurum_kodu = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                    $batch_data[] = array(
                        "ogr_no" => $ogr_no,
                        "ogr_adi_soyadi" => $ogr_adi_soyadi,
                        "puan" => $puan,
                        "kurum_kodu" => $kurum_kodu,
                        "sinav_id" => $sinav_id,
                        "user_id" => $this->ion_auth->user()->row()->id,
                        "status" => $puan == "G" ? 0 : 1,
                    );
                }
            }

            // Eğer dizi boş değilse toplu ekleme yap
            if (!empty($batch_data)) {
                $result = $this->sinav_puanlari_model->insert_batch($batch_data);
            }
        }

        // Sınav durumunu "dosya yüklendi" olarak güncelle
        $update = $this->sinavlar_model->update(
            array("sinavlar.id" => $sinav_id),
            array("sinavlar.yayin_durumu" => 2)
        );

        _alert_message(
            $result || $update,
            "sinavlar/analyze/$sinav_id",
            "Toplu puan listesi (Toplam Öğrenci Sayısı: " . count($batch_data) . ") başarıyla aktarıldı. Analiz işlemine başlayabilirsiniz.",
        );
    }

    /**
     * @param array $puan_dagilimi
     * @return string
     */
    private function draw_bar_chart(array $puan_dagilimi = array()): string
    {
        // Genişlik ve yükseklik ayarları
        $width = 800;
        $height = 340;
        $bar_height = 30;
        $margin = 50;
        $label_margin = 140; // Etiketlerin genişliği

        // Grafik alanı oluştur
        $image = imagecreatetruecolor($width, $height);

        // Renk tanımları
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 0, 102, 204);

        // Arka planı beyaz yap
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Başlık ekle
        $font = 5;
        $title = "PUAN DAGILIMI";
        imagestring($image, $font, ($width / 2) - (strlen($title) * imagefontwidth($font)) / 2, 10, $title, $black);

        // Y eksenindeki puan aralıklarının toplam sayısını al
        $num_bars = count($puan_dagilimi);
        $max_value = max(array_column($puan_dagilimi, 'ogrenci_sayisi'));

        foreach ($puan_dagilimi as $index => $data) {
            $y1 = $margin + $index * ($bar_height + 20);
            $y2 = $y1 + $bar_height;
            $bar_width = ($data['ogrenci_sayisi'] / $max_value) * ($width - $label_margin - $margin);

            // Çubuğu çiz
            imagefilledrectangle($image, $label_margin, $y1, $label_margin + $bar_width, $y2, $gray);

            // Çubuk üstüne öğrenci sayısını yaz
            imagestring($image, $font, $label_margin + $bar_width + 10, $y1 + ($bar_height / 4), $data['ogrenci_sayisi'], $black);

            // Y eksenine puan aralıklarını yaz
            imagestring($image, $font, 10, $y1 + ($bar_height / 4), $data['puan_araligi'], $black);
        }

        // Y ekseni için çizgi çiz
        imageline($image, $label_margin, $margin - 10, $label_margin, $height - $margin, $black);

        // Grafiği dosya olarak kaydetme
        $upload_dir = FCPATH . 'uploads/graphs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Klasör yoksa oluştur
        }

        $file_path = $upload_dir . 'puan_dagilimi_' . time() . '.png';
        imagepng($image, $file_path);
        imagedestroy($image);

        // Dosya yolunu döndür
        return 'uploads/graphs/' . basename($file_path);
    }
}
