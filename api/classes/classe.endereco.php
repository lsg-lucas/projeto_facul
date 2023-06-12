<?php

class Endereco {

    private $id;
    private $cep;
    private $logradouro;
    private $numero;
    private $cidade;
    private $estado;
    private $bairro;
    private $conexao;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function __construct()
    {
        $this->conexao = new Conexao();
    }

    public function Adicionar()
    {
        $this->conexao->query("INSERT INTO endereco_cliente (cep, logradouro, numero, cidade, estado, bairro) VALUES (:cep, :logradouro, :numero, :cidade, :estado, :bairro)");
        $this->conexao->bind("cep", $this->getCep());
        $this->conexao->bind("logradouro", $this->getLogradouro());
        $this->conexao->bind("numero", $this->getNumero());
        $this->conexao->bind("cidade", $this->getCidade());
        $this->conexao->bind("estado", $this->getEstado());
        $this->conexao->bind("bairro", $this->getBairro());
        $this->conexao->executa();
        $rs = $this->conexao->ultimoIdInserido();

        if ($rs) {
            return $rs;
        } else {
            return false;
        }
    }

    public function Modificar(){
        $this->conexao->query("
        
        UPDATE endereco_cliente 
        SET cep = :cep, 
        logradouro = :logradouro, 
        numero = :numero, 
        cidade = :cidade, 
        estado = :estado, 
        bairro = :bairro
        WHERE id = :id ");

        $this->conexao->bind("cep", $this->getCep());
        $this->conexao->bind("logradouro", $this->getLogradouro());
        $this->conexao->bind("numero", $this->getNumero());
        $this->conexao->bind("cidade", $this->getCidade());
        $this->conexao->bind("estado", $this->getEstado());
        $this->conexao->bind("bairro", $this->getBairro());
        $this->conexao->bind("id", $this->getId());

        if ($this->conexao->executa()) {
            return true;
        } else {
            return false;
        }
    }

    public function Remover()
    {
        $this->conexao->query("UPDATE endereco_cliente SET excluido = NOW() WHERE id = :id");
        $this->conexao->bind("id", $this->getId());

        if ($this->conexao->executa()) {
            return true;
        } else {
            return false;
        }
    }

}
