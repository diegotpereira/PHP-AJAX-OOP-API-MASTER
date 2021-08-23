<?php

class Produto
{
    private $conn;
    private  $tabela_nome = "produtos";

    // propriedade dos objetos
    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $categoria_id;
    public $categoria_nome;
    public $criado;

    // construtor com $db como conexão de banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // function lerProdutos
    function ler()
    {
        // selecionar consultar todos
        $query =
            "SELECT c.nome as categoria_nome, p.id, p.nome, p.descricao, p.preco, p.categoria_id, p.criado
                FROM 
                    " . $this->tabela_nome . " p LEFT JOIN
                        categorias c
                            ON p.categoria_id = c.id
                                ORDER BY 
                                    p.criado DESC";

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);

        // executar consulta
        $stmt->execute();

        return $stmt;
                            
    }

    // function buscar por id
    function lerUm()
    {
        // selecionar consultar todos
        $query = "SELECT
            c.nome as categoria_nome, p.id, p.nome, p.descricao, p.preco, p.categoria_id, p.criado
                FROM
                    " . $this->tabela_nome . " p
                    LEFT JOIN
                        categorias c
                            ON p.categoria_id = c.id
                            WHERE
                                p.id = ?
                                    LIMIT
                                        0,1";

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);

        // ID de ligação do produto a ser atualizado
        $stmt->bindParam(1, $this->id);

        // executar consulta
        $stmt->execute();

        // obter linha recuperada
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // definir valores para propriedades do objeto
        $this->nome= $row['nome'];
        $this->preco= $row['preco'];
        $this->descricao= $row['descricao'];
        $this->categoria_id= $row['categoria_id'];
        $this->categoria_nome = $row['categoria_nome'];
        
    }
    function criar() 
    {
        // consulta para inserir registro
            $query = "INSERT INTO
            " . $this->tabela_nome . "
        SET
            nome=:nome, preco=:preco, descricao=:descricao, categoria_id=:categoria_id, criado=:criado";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->preco=htmlspecialchars(strip_tags($this->preco));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->categoria_id=htmlspecialchars(strip_tags($this->categoria_id));
        $this->criado=htmlspecialchars(strip_tags($this->criado));

        // bind values
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":criado", $this->criado);

        // execute query
        if($stmt->execute()){
        return true;
        }

        return false;
    }

    function atualizar() 
    {
        // consulta para atualizar registro
            $query = "UPDATE
            " . $this->tabela_nome . "
            SET
                nome = :nome, 
                preco = :preco, 
                descricao = :descricao, 
                categoria_id = :categoria_id
            WHERE 
                id = :id";    

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->preco=htmlspecialchars(strip_tags($this->preco));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->categoria_id=htmlspecialchars(strip_tags($this->categoria_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':id', $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function deletar() 
    {
        // consulta para atualizar registro
        $query = "DELETE FROM " . $this->tabela_nome . " WHERE id = ?";   

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;    
        }

        return false;
    }

    function buscar($palavraChave)
    {
        // selecionar consultar todos
        $query = "SELECT
                c.nome as category_nome, p.id, p.nome, p.descricao, p.preco, p.categoria_id, p.criado
            FROM
                " . $this->tabela_nome . " p
                LEFT JOIN
                    categorias c
                        ON p.categoria_id = c.id
            WHERE
                p.nome LIKE ? OR p.descricao LIKE ? OR c.nome LIKE ?
            ORDER BY
                p.criado DESC";

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);

        // sanitize
        $palavraChave=htmlspecialchars(strip_tags($palavraChave));
        $palavraChave = "%{$palavraChave}%";

        // bind values
        $stmt->bindParam(1, $palavraChave);
        $stmt->bindParam(2, $palavraChave);
        $stmt->bindParam(3, $palavraChave);

        // executar consulta
        $stmt->execute();

        return $stmt;
                            
    }

    function lerPaginacao($numero_do_registro, $registros_por_pagina)
    {
        // selecionar consultar todos
        $query = "SELECT
                c.nome as category_nome, p.id, p.nome, p.descricao, p.preco, p.categoria_id, p.criado
            FROM
                " . $this->tabela_nome . " p
                LEFT JOIN
                    categorias c
                        ON p.categoria_id = c.id
                            ORDER BY
                                p.criado DESC
                                LIMIT ?, ?";

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(1, $numero_do_registro, PDO::PARAM_INT);
        $stmt->bindParam(2, $registros_por_pagina, PDO::PARAM_INT);

        // executar consulta
        $stmt->execute();

        return $stmt;
                            
    }

    function rowCount()
    {
        // consulta para atualizar registro
        $query = "SELECT COUNT(*) as total_linhas FROM " . $this->tabela_nome. ""; 

        //preparar declaração de consulta
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_linhas'];
    }
}
