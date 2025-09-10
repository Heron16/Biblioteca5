document.addEventListener('DOMContentLoaded', function() {
    if (!$.fn.DataTable.isDataTable('#tblLibros')) {
        $('#tblLibros').DataTable({
        ajax: {
            url: base_url + 'Libros/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'titulo' },
            { data: 'autor' },
            { data: 'editorial' },
            { data: 'materia' },
            { data: 'cantidad' },
            { data: 'estado' },
            { data: 'acciones' }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    }

    if (document.getElementById('tblReservas') && !$.fn.DataTable.isDataTable('#tblReservas')) {
        $('#tblReservas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
    }
    
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000"
        };
    }

    window.abrirReserva = function(id, titulo) {
        document.getElementById('libro').value = id;
        document.getElementById('titulo_libro').value = titulo;
        $('#reservar').modal('show');
    }

    $('#frmReservar').submit(function(e) {
        e.preventDefault();
        const libro = document.getElementById('libro').value;
        const fecha_reserva = document.getElementById('fecha_reserva').value;
        const observacion = document.getElementById('observacion').value;

        if (libro == '' || fecha_reserva == '') {
            Swal.fire({
                title: 'Error!',
                text: 'Todos os campos são obrigatórios',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        const isAngel = document.querySelector('.app-sidebar__user-designation') && 
                        document.querySelector('.app-sidebar__user-designation').textContent === 'angel';

        const url = base_url + 'Reserva/reservar';
        const formData = new FormData();
        formData.append('libro', libro);
        formData.append('fecha_reserva', fecha_reserva);
        formData.append('observacion', observacion);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            $('#reservar').modal('hide');
            
            if (data.icono === 'success' && isAngel && typeof toastr !== 'undefined') {
                const tituloLivro = document.getElementById('titulo_libro').value;
                toastr.success('O livro "' + tituloLivro + '" foi emprestado com sucesso!', 'Empréstimo Realizado');
            }
            
            Swal.fire({
                title: isAngel ? 'Empréstimo Realizado!' : 'Reserva Realizada!',
                text: data.msg,
                icon: data.icono || 'success',
                confirmButtonText: isAngel ? 'Ver Meus Empréstimos' : 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (isAngel) {
                        window.location.href = base_url + 'Prestamos';
                    } else {
                        location.reload();
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erro:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Ocorreu um erro ao processar a ' + (isAngel ? 'empréstimo' : 'reserva') + '.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});