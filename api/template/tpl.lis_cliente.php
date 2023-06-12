<?php
$objCliente = new Cliente();
$listar = $objCliente->ListarCLiente();
?>
<div class="col-md-12" style="padding: 10px;">
    <table class="table  table-striped table-sm">
        <thead>
          <tr>
            <th>ID:</th>
            <th>Nome:</th>
            <th>Telefone:</th>
            <th>Celular:</th>
            <th>E-mail:</th>
            <th>CEP:</th>
            <th>Endereço:</th>
            <th>Nº:</th>
            <th>Cidade:</th>
            <th>Estado:</th>
            <th>Bairro:</th>
            <th>Ações:</th>
          </tr>
        </thead>
        <tbody>
            <? if (count($listar) > 0 ){
                foreach ($listar AS $linha){
                    echo "<tr>
                            <td>".$linha->id."</td>
                            <td>".$linha->nome."</td>
                            <td>".$linha->telefone."</td>
                            <td>".$linha->celular."</td>
                            <td>".$linha->email."</td>
                            <td>".$linha->cep."</td>
                            <td>".$linha->logradouro."</td>
                            <td>".$linha->numero."</td>
                            <td>".$linha->cidade."</td>
                            <td>".$linha->estado."</td>
                            <td>".$linha->bairro."</td>
                            <td>
                                <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick='ExcluirCliente(".$linha->id.")'><i class=\"fa fa-close\" aria-hidden=\"true\"></i></button>
                                <button type=\"button\" class=\"btn btn-primary btn-sm\" onclick='ModificarCliente(".$linha->id.")' title='modificar'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>
                            </td>
                         </tr>";
                }
            }
            ?>
        </tbody>
      </table>
</div>
<script>
    function ExcluirCliente(id)
    {
        Swal.fire({
            title: 'Confirme por favor!',
            text: "Deseja excluir esse registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim!',
           cancelButtonText: 'Não!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("../../api/index.php?comando=remover_cliente&id="+id,
                    function(response){
                        if(response["codigo"] == 1){
                            Swal.fire('Excluído!','Registro foi excluído com sucesso!','success');
                            AtualizarGridCliente();
                        }
                        else{
                            Swal.fire(
                                'Erro!',
                                'Não foi possível excluir o registro!',
                                'danger'
                            );
                        }
                    }, "json"
                );
            }
        });
    }

    function ModificarCliente(id) {

        $.get( "../../api/index.php?comando=editar_cliente&id="+id, function( data ) {
            var info = JSON.parse(data);

            console.log(info['nome'])

           setTimeout(function(){

               $('#id_cli').val(info['id']);
               $('#id_endereco').val(info['id_endereco']);
               $('#nome').val(info['nome']);
               $('#telefone').val(info['telefone']);
               $('#celular').val(info['celular']);
               $('#email').val(info['email']);
               $('#cep').val(info['cep']);
               $('#logradouro').val(info['logradouro']);
               $('#numero_residencial').val(info['numero']);
               $('#cidade').val(info['cidade']);
               $('#estado').val(info['estado']);
               $('#bairro').val(info['bairro']);
           }, 1500)
        });

        $('#cadastro-tab').click();
        // alert(id)
    }

</script>