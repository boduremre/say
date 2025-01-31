<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//https://stackoverflow.com/questions/16456819/codeigniter-create-a-layout-template-library
class Layout
{
    public array $data = array();
    public string|null $view = null;
    public string|null $title = null;
    public string|null $view_folder = null;
    public string $layouts_folder = 'layouts';
    public string $layout = 'default';
    var object $obj;

    function __construct()
    {
        $this->obj =& get_instance();
    }

    /**
     * @param $layout
     * @return void
     */
    function set_layout($layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @param $layout_folder
     * @return void
     */
    function set_layout_folder($layout_folder): void
    {
        $this->layouts_folder = $layout_folder;
    }

    /**
     * @return void
     */
    function render(): void
    {
        $controller = $this->obj->router->fetch_class();
        $method = $this->obj->router->fetch_method();

        $view_folder = !($this->view_folder) ? $controller . '.views' : $this->view_folder . '.views';
        $view = !($this->view) ? $method : $this->view;

        $loaded_data = array(
            "view" => $view_folder . '/' . $view,
            "data" => $this->data,
            "title" => $this->title
        );

        $layout_path = '/' . $this->layouts_folder . '/' . $this->layout;

        $this->obj->load->view($layout_path, $loaded_data);
    }
}