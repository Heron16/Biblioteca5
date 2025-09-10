<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-book"></i> Reserva de Livros</h1>
        <p>Reserva de livros com pagamento de R$ 5,00</p>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Livros Disponíveis para Reserva</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mt-4" id="tblLibros">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                <th>Matéria</th>
                                <th>Quantidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Minhas Reservas</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mt-4" id="tblReservas">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Livro</th>
                                <th>Data da Reserva</th>
                                <th>Observação</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['reservas']) && !empty($data['reservas'])) { 
                                foreach ($data['reservas'] as $reserva) { 
                                    $estado = $reserva['estado'] == 1 ? '<span class="badge badge-success">Ativa</span>' : '<span class="badge badge-danger">Cancelada</span>';
                            ?>
                                <tr>
                                    <td><?php echo $reserva['id']; ?></td>
                                    <td><?php echo $reserva['titulo']; ?></td>
                                    <td><?php echo $reserva['fecha_reserva']; ?></td>
                                    <td><?php echo $reserva['observacion']; ?></td>
                                    <td><?php echo $estado; ?></td>
                                    <td>
                                        <a href="<?php echo base_url; ?>Reserva/verQRCode/<?php echo $reserva['id']; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-qrcode"></i> Ver QR Code</a>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="reservar" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Reservar Livro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmReservar" method="post">
                    <div class="form-group">
                        <label for="titulo_libro">Livro</label>
                        <input id="titulo_libro" class="form-control" type="text" disabled>
                        <input id="libro" type="hidden" name="libro">
                    </div>
                    <div class="form-group">
                        <label for="fecha_reserva">Data da Reserva</label>
                        <input id="fecha_reserva" class="form-control" type="date" name="fecha_reserva" value="<?php echo date("Y-m-d"); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observação</label>
                        <textarea id="observacion" class="form-control" placeholder="Observação" name="observacion" rows="3"></textarea>
                    </div>
                    <div class="alert alert-info">
                        <p>Valor da reserva: <strong>R$ 5,00</strong></p>
                    </div>
                    <button class="btn btn-primary" type="submit" id="btnReservar">Reservar e Gerar Pagamento</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="qrcode_modal" class="modal fade" role="dialog" aria-labelledby="qrcode-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="qrcode-modal-title">QR Code para Pagamento</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4>Valor: R$ 5,00</h4>
                <p>Escaneie o QR Code abaixo para realizar o pagamento da reserva</p>
                <div id="qrcode_container" class="my-4">
                    
                </div>
                <p id="qrcode_text" class="text-muted"></p>
                <div class="alert alert-success">
                    <p>Após o pagamento, sua reserva será confirmada automaticamente.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $.fn.dataTable.ext.render.libroAcciones = function() {
            return function(data, type, row) {
                if (type === 'display') {
                    return `<button class="btn btn-primary" type="button" onclick="frmReservar(${row.id}, '${row.titulo}');"><i class="fa fa-calendar-plus-o"></i> Reservar</button>`;
                }
                return data;
        */
            };
        };
        */

    
        /* Comentado para evitar conflitos com a inicialização no arquivo reserva.js
        tblLibros.column(6).render($.fn.dataTable.ext.render.libroAcciones());
        tblLibros.draw();
        }*/

    
        $('#frmReservar').submit(function(e) {
            e.preventDefault();
            const libro = $('#libro').val();
            const fecha_reserva = $('#fecha_reserva').val();
            const observacion = $('#observacion').val();
            
            if (libro == '' || fecha_reserva == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Todos os campos são obrigatórios'
                });
                return;
            }
            
            const url = base_url + 'Reserva/reservar';
            const frm = document.getElementById('frmReservar');
            const http = new XMLHttpRequest();
            http.open('POST', url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.msg == 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: 'Reserva realizada com sucesso. O QR code para pagamento será aberto em uma nova aba.'
                        });
                        frm.reset();
                        $('#reservar').modal('hide');
                    
                        window.open(res.redirect, '_blank');
                    
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: res.msg
                        });
                    }
                }
            }
        });
    });

    function frmReservar(id, titulo) {
        document.getElementById('titulo_libro').value = titulo;
        document.getElementById('libro').value = id;
        $('#reservar').modal('show');
    }
</script>
<?php include "Views/Templates/footer.php"; ?>