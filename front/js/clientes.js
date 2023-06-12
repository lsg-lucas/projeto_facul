
$(document).ready(function(){
    AtualizarGridCliente();
});

function AtualizarGridCliente(pagina,busca,filtro,ordem)
{
    var load = '<div class="d-flex justify-content-center">\n' +
        '     <div class="spinner-grow" style="width: 3rem; height: 3rem;"  role="status">\n' +
        '         <span class="sr-only">Loading...</span>\n' +
        '     </div>\n' +
        ' </div>';
    $('#conteudo_cliente').html(load);
    $('#pagina').val(pagina);
    $('#filtro').val(filtro);
    $('#ordem').val(ordem);
    $('#busca').val(busca);

    $("#conteudo_cliente").load("../../api/index.php?comando=ajax_listar_clientes");
}


