<?php defined('BASEPATH') or exit('No direct script access allowed');

class Okullar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //Auth Control
        if (!$this->ion_auth->logged_in())
            redirect('auth/login');

        //load models
        $this->load->model("okullar_model");

        //set variables
        $this->layout->title = "Okullar";
        $this->layout->active_link = "okullar";
    }

    /**
     * @return void
     */
    public function index(): void
    {
        //get okullar
        $this->layout->data["okullar"] = $this->okullar_model->all();

        $this->layout->render();
    }

    /**
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        // get okul from id
        $this->layout->data["okul"] = $this->okullar_model->get(array("okullar.id" => $id));

        $this->layout->render();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        is_post_request();

        $id = $this->input->post("id", TRUE);

        $form_values = array(
            "kurum_kodu" => $this->input->post("kurum_kodu", TRUE),
            "kurum_adi" => $this->input->post("kurum_adi", TRUE),
            "adres" => $this->input->post("adres", TRUE),
            "web" => $this->input->post("web", TRUE),
            "eposta" => $this->input->post("eposta", TRUE),
            "eposta2" => $this->input->post("eposta2", TRUE),
            "telefon" => $this->input->post("telefon", TRUE),
            "durum" => $this->input->post("durum", TRUE),
        );

        $update = $this->okullar_model->update($id, $form_values);
       _alert_message($update);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        if (!empty($id)) {
            //$delete = $this->okullar_model->delete(array('okullar.ID' => $id));
            _alert_error_message("okullar/index", "Okul bilgisi silinemez!");
        }
    }

}
