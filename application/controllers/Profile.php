<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('auth/login', 'refresh');
    }

    public function index()
    {
        $this->layout->render();
    }

    public function update()
    {
        if (is_post()) {

            $this->form_validation->set_rules('first_name', 'Ad', 'required');
            $this->form_validation->set_rules('last_name', 'Soyad', 'required');
            $this->form_validation->set_rules('phone', 'Telefon', 'required');
            $this->form_validation->set_rules('email', 'Eposta', 'required|valid_email');

            if ($this->form_validation->run() === FALSE) {
                redirect('profile', 'refresh');
            } else {
                $id =  $this->input->post("id", TRUE);
                $data = array(
                    'first_name' => $this->input->post("first_name", TRUE),
                    'last_name' => $this->input->post("last_name", TRUE),
                    'email' => $this->input->post("email", TRUE),
                    'phone' => $this->input->post("phone", TRUE)
                );

                if($this->ion_auth->update($id, $data))
                {
                    swal("İşlem Başarılı", "Kişisel bilgileriniz güncellendi.", "profile");
                }
            }
        }
    }
}
