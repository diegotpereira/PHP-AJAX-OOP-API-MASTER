<?php
// cabeçalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../objetos/produto.php';

// a conexão do banco de dados estará aqui
$database = new Database();
$db = $database->getConnection();

// incializar o objeto
$produto = new Produto($db);

//obter palavras-chave
$palavraChave = isset($_GET["s"]) ? $_GET["s"] : "";

// consultar produtos
$stmt = $produto->buscar($palavraChave);
$num = $stmt->rowCount();

// verifique se mais de 0 registro encontrado
if ($num>0) {
    # code...
    // array de produtos
    $produtos_arr = array();
    $produtos_arr["registros"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        # code...
        // extrair linha
        // fetch() é mais rápido que fatchAll()
        extract($row);

        $produto_item = array(
            "id" => $id,
            "nome" => $nome,
            "descricao" => html_entity_decode($descricao),
            "preco" => $preco,
            "categoria_id" => $categoria_id,
        );

        array_push($produtos_arr["registros"], $produto_item);
    }

    // define código resposta  - 200 OK
    http_response_code(200);

    echo json_encode($produtos_arr);
} else {
    # code...
     // definir o código de resposta
     http_response_code(404);

     //diga ao usuário que nenhum produto foi encontrado
     echo json_encode(
         array("message" => "Produto não encontrado!.")
     );
}


?>