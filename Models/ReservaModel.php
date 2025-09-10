<?php
class ReservaModel extends Query
{
    private $id, $id_usuario, $id_libro, $fecha_reserva, $observacion, $qr_code, $estado;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getReservas($id_usuario = null)
    {
        $where = "";
        if ($id_usuario != null) {
            $where = " WHERE r.id_usuario = $id_usuario";
        }

        $sql = "SELECT r.id, r.id_usuario, r.id_libro, DATE_FORMAT(r.fecha_reserva,'%d/%m/%Y') AS fecha_reserva, 
                r.observacion, r.qr_code, r.estado, u.nombre as nombre_usuario, l.titulo 
                FROM reservas r 
                INNER JOIN usuarios u ON r.id_usuario = u.id 
                INNER JOIN libro l ON r.id_libro = l.id
                $where ORDER BY r.id DESC";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function insertarReserva($id_usuario, $id_libro, $fecha_reserva, $observacion)
    {
        $this->id_usuario = $id_usuario;
        $this->id_libro = $id_libro;
        $this->fecha_reserva = $fecha_reserva;
        $this->observacion = $observacion;
        
        $this->qr_code = $this->generarQRCode($id_usuario, $id_libro);
        $this->estado = 1;
        
        $query = "INSERT INTO reservas(id_usuario, id_libro, fecha_reserva, observacion, qr_code, estado) 
                 VALUES (?,?,?,?,?,?)";
        $datos = array($this->id_usuario, $this->id_libro, $this->fecha_reserva, $this->observacion, $this->qr_code, $this->estado);
        $data = $this->insert($query, $datos);
        return $data;
    }

    public function getReserva($id)
    {
        $sql = "SELECT r.id, r.id_usuario, r.id_libro, DATE_FORMAT(r.fecha_reserva,'%d/%m/%Y') AS fecha_reserva, 
                r.observacion, r.qr_code, r.estado, u.nombre as nombre_usuario, l.titulo 
                FROM reservas r 
                INNER JOIN usuarios u ON r.id_usuario = u.id 
                INNER JOIN libro l ON r.id_libro = l.id
                WHERE r.id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function actualizarEstadoReserva($id, $estado)
    {
        $sql = "UPDATE reservas SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    
    private function generarQRCode(int $id_usuario, int $id_libro) {
        $reserva_id = uniqid('reserva_');
        
        $sql = "SELECT l.titulo, a.autor, e.editorial 
                FROM libro l 
                INNER JOIN autor a ON l.id_autor = a.id 
                INNER JOIN editorial e ON l.id_editorial = e.id 
                WHERE l.id = $id_libro";
        $libro_info = $this->select($sql);
        
        $data = array(
            'id_reserva' => $reserva_id,
            'id_usuario' => $id_usuario,
            'id_libro' => $id_libro,
            'titulo' => $libro_info['titulo'],
            'autor' => $libro_info['autor'],
            'editorial' => $libro_info['editorial'],
            'fecha' => date('Y-m-d H:i:s'),
            'valor' => '5.00',
            'moneda' => 'BRL'
        );
        
        $json_data = json_encode($data);
        
        $filename = 'QR_' . $id_usuario . '_' . $id_libro . '_' . time() . '.png';
        $filepath = 'Assets/img/qrcodes/' . $filename;
        
        if (!file_exists('Assets/img/qrcodes/')) {
            mkdir('Assets/img/qrcodes/', 0777, true);
        }
        
        $qr_url = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($json_data) . '&choe=UTF-8';
        
        file_put_contents($filepath, file_get_contents($qr_url));
        
        return $filename;
    }
}