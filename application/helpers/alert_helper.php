<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('alert_message')) {
    /**
     * @param string $text
     * @param string $type
     * @param string $title
     * @param string $redirect_uri
     * @return void
     */
    function alert_message(string $text, string $type = "", string $title = "", string $redirect_uri = ""): void
    {
        $message = array(
            "title" => empty($title) ? 'İşlem Başarılı' : $title,
            "text" => empty($text) ? 'Mesaj' : $text,
            "type" => empty($type) ? 'success' : $type
        );

        $t = &get_instance();
        $t->session->set_flashdata("alert", $message);

        if (empty($redirect_uri))
            redirect($t->router->fetch_class() . "/index", 'refresh');
        else
            redirect($redirect_uri);
    }
}

if (!function_exists('_alert_message')) {
    /**
     * @param bool $result
     * @param string $text
     * @param string $type
     * @param string $title
     * @param string $redirect_uri
     * @return void
     */
    function _alert_message(bool $result, string $redirect_uri = "", string $text = "İşlem Başarılı", string $type = "", string $title = ""): void
    {
        if ($result) {
            $message = array(
                "title" => empty($title) ? 'Bilgi' : $title,
                "text" => empty($text) ? 'İşlem Başarılı' : $text,
                "type" => empty($type) ? 'success' : $type
            );
        } else {
            $message = array(
                "title" => 'Hata',
                "text" => 'İşlem esnasında hata meydana geldi!',
                "type" => 'error'
            );
        }

        $t = &get_instance();
        $t->session->set_flashdata("alert", $message);
        $t->session->userdata("alert");

        if (empty($redirect_uri))
            redirect($t->router->fetch_class() . "/index", 'refresh');
        else
            redirect($redirect_uri);
    }
}

if (!function_exists('_alert_error_message')) {
    function _alert_error_message(string $redirect_uri = "", string $text = "İşlem esnasında hata meydana geldi!"): void
    {
        $message = array(
            "title" => 'Hata',
            "text" => $text,
            "type" => 'error'
        );

        $t = &get_instance();
        $t->session->set_flashdata("alert", $message);
        $t->session->userdata("alert");

        if (empty($redirect_uri))
            redirect($t->router->fetch_class() . "/index", 'refresh');
        else
            redirect($redirect_uri);
    }
}