<?php

class Cliente
{
    private $id;
    private $nome;
    private $conexao;
    private $telefone;
    private $celular;
    private $email;
    private $id_endereco;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }


    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getIdEndereco()
    {
        return $this->id_endereco;
    }

    public function setIdEndereco($id_endereco)
    {
        $this->id_endereco = $id_endereco;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function __construct()
    {
        $this->conexao = new Conexao();
    }

    public function Adicionar()
    {
        $this->conexao->query("INSERT INTO clientes (nome, telefone, celular, email, id_endereco) VALUES (:nome, :telefone, :celular, :email, :id_endereco)");
        $this->conexao->bind("nome", $this->getNome());
        $this->conexao->bind("telefone", $this->getTelefone());
        $this->conexao->bind("celular", $this->getCelular());
        $this->conexao->bind("email", $this->getEmail());
        $this->conexao->bind("id_endereco", $this->getIdEndereco());

        if ($this->conexao->executa()) {
            return true;
        } else {
            return false;
        }
    }

    public function ListarCLiente()
    {
        $this->conexao->query("
            SELECT clientes.id,
            clientes.nome,
            clientes.telefone,
            clientes.celular,
            clientes.email,
            endereco_cliente.cep,
            endereco_cliente.logradouro,
            endereco_cliente.numero,
            endereco_cliente.cidade,
            endereco_cliente.estado,
            endereco_cliente.bairro
            FROM clientes 
            LEFT JOIN endereco_cliente ON(clientes.id_endereco = endereco_cliente.id)
            WHERE clientes.excluido IS NULL ");
        $rs = $this->conexao->resultados();
        return $rs;
    }

    public function Editar()
    {
        $this->conexao->query("
            SELECT 
            clientes.id,
            clientes.nome,
            clientes.telefone,
            clientes.celular,
            clientes.email,
            clientes.id_endereco,
            endereco_cliente.cep,
            endereco_cliente.logradouro,
            endereco_cliente.numero,
            endereco_cliente.cidade,
            endereco_cliente.estado,
            endereco_cliente.bairro
            FROM clientes 
            LEFT JOIN endereco_cliente ON(clientes.id_endereco = endereco_cliente.id)
            WHERE clientes.id = :id ");
        $this->conexao->bind("id", $this->getId());
        $rs = $this->conexao->resultado();
        return $rs;

    }

    public function Modificar()
    {
        $this->conexao->query("
        
        UPDATE clientes 
        SET nome = :nome, 
        telefone = :telefone, 
        celular = :celular,
        email = :email
        WHERE id = :id ");

        $this->conexao->bind("nome", $this->getNome());
        $this->conexao->bind("telefone", $this->getTelefone());
        $this->conexao->bind("celular", $this->getCelular());
        $this->conexao->bind("email", $this->getEmail());
        $this->conexao->bind("id", $this->getId());

        if ($this->conexao->executa()) {
            return true;
        } else {
            return false;
        }
    }

    public function Remover()
    {
        $this->conexao->query("UPDATE clientes SET excluido = NOW() WHERE id = :id");
        $this->conexao->bind("id", $this->getId());

        if ($this->conexao->executa()) {
            return true;
        } else {
            return false;
        }
    }

    public function BuscarIdEndereco()
    {
        $this->conexao->query("
            SELECT 
            clientes.id_endereco
            FROM clientes 
            WHERE clientes.id = :id ");
        $this->conexao->bind("id", $this->getId());
        $rs = $this->conexao->resultado();
        return $rs;
    }



}



