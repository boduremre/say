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

        //set variables
        $this->layout->data["title"] = "Sınavlar";
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

        $update = $this->sinavlar_model->update($this->input->post("dogrulama_kodu"), $form_values);
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

    /**
     * @desc Kaydedilen sınavın analiz edilmesini sağlar.
     * @param string $id
     * @return void
     */
    public function do_analyze(string $id): void
    {
        $this->load->model('sinav_puanlari_model');
        $istatistikler = array(
            "sinav_bilgisi" => $this->sinavlar_model->get(array('sinavlar.id' => $id)),
            "toplam_ogrenci_sayisi" => $this->sinav_puanlari_model->count(array('sinav_id' => $id)),
            "min_puan" => $this->sinav_puanlari_model->get_min_puan(array('sinav_id' => $id)),
            "max_puan" => $this->sinav_puanlari_model->get_max_puan(array('sinav_id' => $id)),
            "avg_puan" => $this->sinav_puanlari_model->get_avg_puan(array('sinav_id' => $id)),
            "standart_sapma" => $this->sinav_puanlari_model->get_stddev_puan($id),
            "puan_kurum" => $this->sinav_puanlari_model->get_min_max_avg_puan_kurum(array('sinav_id' => $id)),
        );

        download_json("istatistikler.json", $istatistikler);

        //$this->layout->render();
    }

    public function excel_upload(): void
    {
        // gelen istek post isteği mi
        is_post_request();

        //load library and models
        $this->load->library('php_excel');
        $this->load->model('sinav_puanlari_model');

        $sinav_id = $this->input->post('sinav_id', TRUE);
        $result = false;

        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                //$highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $ogr_no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $ogr_adi_soyadi = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $puan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $kurum_kodu = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                    $data = array(
                        "ogr_no" => $ogr_no,
                        "ogr_adi_soyadi" => $ogr_adi_soyadi,
                        "puan" => $puan,
                        "kurum_kodu" => $kurum_kodu,
                        "sinav_id" => $sinav_id,
                        "user_id" => $this->ion_auth->user()->row()->id,
                    );

                    $result = $this->sinav_puanlari_model->create($data);
                }
            }
        }

        _alert_message($result, "sinavlar/analyze/$sinav_id", "Toplu puan listesi (Toplam Öğrenci Sayısı: " . --$highestRow . ") başarıyla aktarıldı.");
    }
}
