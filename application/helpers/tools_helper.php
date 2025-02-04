<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('dd')) {
    /**
     * @param $arr
     * @return void
     */
    function dd($arr): void
    {
        print("<pre>" . print_r($arr, true) . "</pre>");
        die();
    }
}

if (!function_exists('pa')) {
    /**
     * @param $arr
     * @return void
     */
    function pa($arr): void
    {
        print("<pre>" . print_r($arr, true) . "</pre>");
    }
}

if (!function_exists('swal')) {
    /**
     * @param string $title
     * @param string $text
     * @param string $redirect_uri
     * @param string $type
     * @return void
     */
    function swal(string $title = "Bilgi", string $text = "İşlem Başarılı", string $redirect_uri = "", string $type = "success"): void
    {
        $alert = array(
            "title" => $title,
            "text" => $text,
            "type" => $type
        );

        $t = &get_instance();
        $t->session->set_flashdata("alert", $alert);

        if (empty($redirect_uri))
            redirect($t->router->fetch_class() . "/index", 'refresh');
        else
            redirect($redirect_uri);
    }
}

if (!function_exists('is_post_request')) {
    /**
     * @return void
     */
    function is_post_request(): void
    {
        // instance
        $t = &get_instance();

        // request method post değilse controller index sayfasına yönlendir
        // sonrasında hata mesajı göster
        if ($t->input->server('REQUEST_METHOD') !== 'POST') {
            $alert = array(
                "title" => 'HATA',
                "text" => 'GEÇERSİZ İSTEK',
                "type" => 'error'
            );

            $t->session->set_flashdata("alert", $alert);
            redirect($t->router->fetch_class() . "/index", 'refresh');
        }
    }
}

if (!function_exists('download_json')) {
    /**
     * JSON formatında dosya indirme
     *
     * @param string $filename Dosya adı
     * @param array $data JSON'a dönüştürülecek veri
     */
    function download_json(string $filename = "data.json", array $data = array()): void
    {
        $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($json_data === false)
            die("JSON encode hatası: " . json_last_error_msg());

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        // header('Content-Length: ' . strlen($json_data)); // Bu satırı kaldır veya aşağıdaki ile değiştir
        // header('Content-Length: ' . mb_strlen($json_data, '8bit'));

        ob_clean();
        flush();
        echo $json_data;
        exit;
    }
}

if (!function_exists('download_xml')) {
    /**
     * XML formatında dosya indirme
     *
     * @param string $filename Dosya adı
     * @param array $data XML'e dönüştürülecek veri
     */
    function download_xml(string $filename, array $data = array()): void
    {
        $xml = new SimpleXMLElement('<sinav_verileri/>');

        foreach ($data as $row) {
            $item = $xml->addChild('kurum');
            foreach ($row as $key => $value) {
                $item->addChild($key, htmlspecialchars($value));
            }
        }

        $xml_output = $xml->asXML();

        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($xml_output));

        echo $xml_output;
        exit;
    }
}

