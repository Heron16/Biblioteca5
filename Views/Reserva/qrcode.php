<?php include "Views/Templates/header.php"; ?>

<link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/reserva.css">

<div class="app-title">
    <div>
        <h1><i class="fa fa-qrcode"></i> QR Code de Pagamento</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url; ?>Reserva">Reservas</a></li>
        <li class="breadcrumb-item active">QR Code</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <div class="tile-body">
                <div class="qr-container">
                    <div class="qr-header">
                        <h2>QR Code para Pagamento</h2>
                        <p>Escaneie o código abaixo para realizar o pagamento da sua reserva</p>
                    </div>
                    
                    <div class="qr-details">
                        <p><strong>Livro:</strong> <?php echo $data['reserva']['titulo']; ?></p>
                        <p><strong>Autor:</strong> <?php echo $data['reserva']['autor']; ?></p>
                        <p><strong>Editora:</strong> <?php echo $data['reserva']['editorial']; ?></p>
                        <p><strong>Data da Reserva:</strong> <?php echo $data['reserva']['fecha_reserva']; ?></p>
                    </div>
                    
                    <div class="qr-payment">
                        <h3>Informações de Pagamento</h3>
                        <p><strong>Valor:</strong> <span class="price">R$ 5,00</span></p>
                        <p><strong>Método:</strong> Pagamento via QR Code</p>
                        <p><strong>Status:</strong> <?php echo ($data['reserva']['estado'] == 1) ? '<span class="badge bg-warning">Pendente</span>' : '<span class="badge bg-success">Confirmado</span>'; ?></p>
                    </div>
                    
                    <div class="qr-code">
                        <img src="<?php echo base_url . 'Assets/img/qrcodes/' . $data['reserva']['qr_code']; ?>" alt="QR Code de Pagamento">
                    </div>
                    
                    <div class="qr-instructions">
                        <h3>Instruções</h3>
                        <ol>
                            <li>Abra o aplicativo do seu banco ou carteira digital</li>
                            <li>Escaneie o QR Code acima</li>
                            <li>Confirme o pagamento de R$ 5,00</li>
                            <li>Após o pagamento, sua reserva será confirmada automaticamente</li>
                        </ol>
                    </div>
                    
                    <a href="<?php echo base_url; ?>Reserva" class="btn-back">Voltar para Reservas</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>