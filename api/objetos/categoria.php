<?php

class Produto
{
    private $conn;
    private  $tabela_nome = "produtos";

    // propriedade dos objetos
    public $id;
    public $nome;
    public $descricao;
    public $criado;

    // construtor com $db como conexão de banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // used by select drop-down list
    function lerTodas()
    {
        // selecionar consultar todos
        $query =
            "SELECT id, nome, descricao
                FROM 
                    " . $this->tabela_nome . "
                            ORDER BY 
                                nome";

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);

        // executar consulta
        $stmt->execute();

        return $stmt;
                            
    }

    function ler()
    {
        // selecionar consultar todos
        $query =
            "SELECT id, nome, descricao
                FROM 
                    " . $this->tabela_nome . "
                            ORDER BY 
                                nome";

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);

        // executar consulta
        $stmt->execute();

        return $stmt;
                            
    }
}