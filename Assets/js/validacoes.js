function validarTelefone(event) {
    const input = event.target;
    let valor = input.value.replace(/\D/g, '');
    

    if (valor.length > 11) {
        valor = valor.substring(0, 11);
    }
    

    if (valor.length > 2) {
        valor = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
    }
    if (valor.length > 10) {
        valor = valor.substring(0, 10) + '-' + valor.substring(10);
    }
    
    input.value = valor;
}


function validarQuantidade(event) {
    const input = event.target;
    input.value = input.value.replace(/\D/g, '');
}


document.addEventListener('DOMContentLoaded', function() {

    const camposTelefone = document.querySelectorAll('input[name="telefono"]');
    camposTelefone.forEach(campo => {
        campo.addEventListener('input', validarTelefone);
    });
    

    const camposQuantidade = document.querySelectorAll('input[type="number"], input[name="cantidad"]');
    camposQuantidade.forEach(campo => {
        campo.addEventListener('input', validarQuantidade);
    });
});