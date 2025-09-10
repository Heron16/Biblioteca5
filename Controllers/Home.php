<?php
class Home extends Controller
{
    public function __construct() {
        session_start();
        if (!empty($_SESSION['activo'])) {
    
            if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'angel') {
                header("location: ".base_url. "Libros");
            } else {
                header("location: ".base_url. "Usuarios");
            }
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    
}
