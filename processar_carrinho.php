<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit;
}

$user_id = $_SESSION['user_id'];

$input = file_get_contents('php://input');
$carrinho = json_decode($input, true);

foreach ($carrinho as $item) {
    $servico_id = $item['id'];
    $nome = $item['nome'];
    $cnpj = $item['cnpj'];
    $telefone = $item['telefone'];
    $servico = $item['serviço'];
    $data_serv = $item['data_serv'];
    $cidade = $item['cidade'];
    $estado = $item['estado'];
    $endereco = $item['endereco'];
    $forma_pagamento = $item['forma_pagamento'];
    $valor = $item['valor'];
    //$data_insercao = date('Y-m-d H:i:s');

    $sql = "INSERT INTO carrinho (usuario_id, nome, cnpj, telefone, servico, data_serv, cidade, estado, endereco,forma_pagamento, valor, data_insercao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("isssssssssds", $user_id, $nome, $cnpj, $telefone, $servico, $data_serv, $cidade, $estado, $endereco, $forma_pagamento, $valor, $data_insercao);
    $stmt->execute();
}

$response = ['status' => 'success'];
echo json_encode($response);
?>
