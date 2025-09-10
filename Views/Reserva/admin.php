<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-book"></i> Gerenciamento de Reservas</h1>
        <p>Visualização e gerenciamento de todas as reservas de livros</p>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Todas as Reservas</h3>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mt-4" id="tblReservasAdmin">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
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
                                    <td><?php echo $reserva['nombre_usuario']; ?></td>
                                    <td><?php echo $reserva['titulo']; ?></td>
                                    <td><?php echo $reserva['fecha_reserva']; ?></td>
                                    <td><?php echo $reserva['observacion']; ?></td>
                                    <td><?php echo $estado; ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="verDetalheReserva(<?php echo $reserva['id']; ?>)"><i class="fa fa-eye"></i> Detalhes</button>
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


<div id="modalDetalhes" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Detalhes da Reserva</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detalhesReserva">
                    
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
        $('#tblReservasAdmin').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
    });

    function verDetalheReserva(id) {
        const url = base_url + 'Reserva/getReserva/' + id;
        const http = new XMLHttpRequest();
        http.open('GET', url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res) {
                    let html = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID da Reserva:</strong> ${res.id}</p>
                                <p><strong>Usuário:</strong> ${res.nombre_usuario}</p>
                                <p><strong>Livro:</strong> ${res.titulo}</p>
                                <p><strong>Data da Reserva:</strong> ${res.fecha_reserva}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Observação:</strong> ${res.observacion}</p>
                                <p><strong>Status:</strong> ${res.estado == 1 ? 'Ativa' : 'Cancelada'}</p>
                                <p><strong>QR Code:</strong> <img src="${base_url}Assets/img/qrcodes/${res.qr_code}" width="150" class="img-thumbnail"></p>
                            </div>
                        </div>
                    `;
                    document.getElementById('detalhesReserva').innerHTML = html;
                    $('#modalDetalhes').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Não foi possível carregar os detalhes da reserva'
                    });
                }
            }
        }
    }
</script>

<?php include "Views/Templates/footer.php"; ?>