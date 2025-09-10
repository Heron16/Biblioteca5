<?php
class Reserva extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        if ($_SESSION['usuario'] == 'angel') {
            $id_usuario = $_SESSION['id_usuario'];
            $reservas = $this->model->getReservas($id_usuario);
            $data['reservas'] = $reservas;
            $this->views->getView($this, "index", $data);
        } else {
            $reservas = $this->model->getReservas(null);
            $data['reservas'] = $reservas;
            $data['admin'] = true;
            $this->views->getView($this, "admin", $data);
        }
    }

    public function reservar()
    {
        if ($_SESSION['usuario'] != 'angel') {
            $msg = array('msg' => 'Acesso não autorizado!', 'icono' => 'warning');
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

        $libro = strClean($_POST['libro']);
        $fecha_reserva = strClean($_POST['fecha_reserva']);
        $observacion = strClean($_POST['observacion']);

        if (empty($libro) || empty($fecha_reserva)) {
            $msg = array('msg' => 'Todos os campos são obrigatórios!', 'icono' => 'warning');
        } else {
            $model = new LibrosModel();
            $verificar_cant = $model->getCantLibro($libro);
            
            if ($verificar_cant['cantidad'] > 0) {
                $id_estudiante = 1;
                $cantidad = 1;
                $fecha_devolucion = date('Y-m-d', strtotime($fecha_reserva . ' + 7 days'));
                
                $prestamosModel = new PrestamosModel();
                $data_prestamo = $prestamosModel->insertarPrestamo($id_estudiante, $libro, $cantidad, $fecha_reserva, $fecha_devolucion, $observacion);
                
                if ($data_prestamo > 0) {
                    $msg = array(
                        'msg' => 'Livro emprestado com sucesso! Devolução em: ' . date('d/m/Y', strtotime($fecha_devolucion)), 
                        'icono' => 'success', 
                        'id' => $data_prestamo
                    );
                } else if ($data_prestamo == "existe") {
                    $msg = array('msg' => 'Este livro já está emprestado para você!', 'icono' => 'warning');
                } else if ($data_prestamo == "limite_excedido") {
                    $msg = array('msg' => 'Você atingiu o limite de livros emprestados! Devolva algum livro antes de fazer um novo empréstimo.', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Erro ao emprestar o livro!', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Livro não disponível para empréstimo!', 'icono' => 'warning');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function verQRCode($id)
    {
        if ($_SESSION['usuario'] != 'angel') {
            header("location: " . base_url . "Libros");
            exit;
        }

        $data = $this->model->getReserva($id);
        if (empty($data)) {
            header('Location: ' . base_url . 'Reserva');
            exit;
        }

        $datos['titulo'] = 'QR Code de Pagamento';
        $datos['reserva'] = $data;
        $this->views->getView($this, "qrcode", $datos);
    }
    
    public function getReserva($id)
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
            exit;
        }
        
        $data = $this->model->getReserva($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}