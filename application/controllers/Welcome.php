<?php defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //load ion_auth
        $this->load->library('ion_auth');

        //auth control
        if (!$this->ion_auth->logged_in())
            redirect('auth/login', 'refresh');

        //load models
        $this->load->model('sinavlar_model', "sinavlar_model");

        //set variables
        $this->layout->title = "Yönetim Paneli";
        $this->layout->active_link = "dashboard";
    }

    /**
     * @return void
     */
    public function index(): void
    {
        $this->layout->data["sinavlar"] = $this->sinavlar_model->all(array("status !=" => 0, "puan !=" => 0));
        $this->layout->render();
    }

    /**
     * @return void
     */
    public function about(): void
    {
        $this->layout->data["user"] = $this->ion_auth->user()->row();
        $this->layout->render();
    }

    /**
     * @return void
     */
    public function variables(): void
    {
        $this->layout->data["user"] = $this->ion_auth->user()->row();
        $this->layout->data["sinavlar"] = $this->sinavlar_model->all();
        $this->layout->render();
    }
}
