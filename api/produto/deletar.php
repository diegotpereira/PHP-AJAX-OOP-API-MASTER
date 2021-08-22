<?php
// cabeçalhos obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../objetos/produto.php';

// a conexão do banco de dados estará aqui
$database = new Database();
$db = $database->getConnection();

// incializar o objeto
$produto = new Produto($db);

// obter dados postados
$data = json_decode(file_get_contents("php://input"));

// definir propriedade de ID do produto a ser editado
$produto->id = $data->id;

// atualizar o produto
if ($produto->deletar()) {
    # code...
    // defina código de resposta 200
    http_response_code(200);

    // diga ao usuário
    echo json_encode(array("message" => "Produto excluído com sucesso!."));

// se não for possível ataulizar o produto, diga ao usuário
} else {
    # code...
    // efinir código de resposta - 503 serviço indisponível
    echo http_response_code(503);

    // diga ao usuário
    echo json_encode(array("message" => "Incapaz de deletar o produto."));

}
?>