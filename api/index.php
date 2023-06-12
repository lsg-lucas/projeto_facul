<?php

include "classes/classe.cliente.php";
include "classes/classe.endereco.php";
include "conexao.php";


switch($_REQUEST['comando']) {

    case "salvar_cliente":
//        Conexao::pr($_REQUEST);

        $objEndereco = new Endereco();
        $objEndereco->setCep($_REQUEST['cep']);
        $objEndereco->setLogradouro($_REQUEST['logradouro']);
        $objEndereco->setNumero($_REQUEST['numero']);
        $objEndereco->setCidade($_REQUEST['cidade']);
        $objEndereco->setEstado($_REQUEST['estado']);
        $objEndereco->setBairro($_REQUEST['bairro']);
        $rs = $objEndereco->Adicionar();

        $objCliente = new Cliente();
        $objCliente->setNome($_REQUEST['nome']);
        $objCliente->setTelefone($_REQUEST['telefone']);
        $objCliente->setCelular($_REQUEST['celular']);
        $objCliente->setEmail($_REQUEST['email']);
        $objCliente->setIdEndereco($rs);

        $rs = $objCliente->Adicionar();
        if ($rs == 1) {
            $msg['codigo'] = 1;
        } else {
            $msg['codigo'] = 0;
        }
        echo json_encode($msg);
        break;

    case "ajax_listar_clientes":

        include "template/tpl.lis_cliente.php";
        break;

    case "editar_cliente":
        $objCliente = new Cliente();
        $objCliente->setId($_REQUEST['id']);
        $rs = $objCliente->Editar();
        echo json_encode($rs);
        break;

    case "modificar_cliente":
        $objEndereco = new Endereco();
        $objEndereco->setCep($_REQUEST['cep']);
        $objEndereco->setLogradouro($_REQUEST['logradouro']);
        $objEndereco->setNumero($_REQUEST['numero']);
        $objEndereco->setCidade($_REQUEST['cidade']);
        $objEndereco->setEstado($_REQUEST['estado']);
        $objEndereco->setBairro($_REQUEST['bairro']);
        $objEndereco->setId($_REQUEST['id_endereco']);
        $objEndereco->Modificar();

        $objCliente = new Cliente();
        $objCliente->setNome($_REQUEST['nome']);
        $objCliente->setTelefone($_REQUEST['telefone']);
        $objCliente->setCelular($_REQUEST['celular']);
        $objCliente->setEmail($_REQUEST['email']);
        $objCliente->setId($_REQUEST['id_cli']);
        $rs = $objCliente->Modificar();

        if ($rs == 1) {
            $msg['codigo'] = 1;
        } else {
            $msg['codigo'] = 0;
        }
        echo json_encode($msg);
        break;

    case "remover_cliente":
        $objEndereco = new Endereco();
        $objCliente = new Cliente();

        $objCliente->setId($_REQUEST['id']);
        $id_endereco = $objCliente->BuscarIdEndereco();

        $objEndereco->setId($id_endereco->id_endereco);
        $rs = $objEndereco->Remover();

        $objCliente->setId($_REQUEST['id']);
        $rs = $objCliente->Remover();

        if ($rs == 1) {
            $msg['codigo'] = 1;
            $msg["mensagem"] = "Sucesso ao Executar a operação";
        } else {
            $msg['codigo'] = 0;
            $msg["mensagem"] = "Erro ao Executar a operação";
        }
        echo json_encode($msg);

        break;




    }