<?php

class Conexao
{
    private $host = 'localhost';
    private $user = 'root';
    private $senha = '';
    private $banco = 'tatuagem';
    private $porta = '3307';
    private $dbh;
    private $stmt;

    //método para construir a conexão
    public function __construct()
    {
        $dsn = 'mysql:host='.$this->host.';port='.$this->porta.';dbname='.$this->banco;
        $opcoes = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn,$this->user,$this->senha,$opcoes);

        } catch (PDOException $e) {
            print "Error!".$e->getMessage()."<br/>";
            die();
        }
    }

    //método para executar a query
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    //método para chama parametros
    public function bind($parametro, $valor, $tipo = null)
    {
        if(is_null($tipo)){
            switch(true){
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;
                default:
                    $tipo = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($parametro,$valor,$tipo);
    }

    //método para executar a função
    public function executa()
    {
        return $this->stmt->execute();
    }

    //método para retorna o resultado com 1 objeto - retorna somente uma linha da pesquisa
    public function resultado()
    {
        $this->executa();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //método para retorna todas as linha da consulta
    public function resultados()
    {
        $this->executa();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //método para retorna o total do count de uma consulta
    public function totalResultados()
    {
        return $this->stmt->rowCount();
    }

    //método para salvar informação no banco e retornar o id
    public function ultimoIdInserido()
    {
        return $this->dbh->lastInsertId();
    }

    //método para dar print_r identado
    public static function pr($dados)
    {
        echo "<pre>";
        print_r($dados);
        echo "</pre>";
    }


}