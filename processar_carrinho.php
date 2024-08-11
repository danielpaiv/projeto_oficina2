<?php
session_start();
include_once('conexao.php');

// Define o fuso horário para o horário oficial de Brasília (UTC-3)
date_default_timezone_set('America/Sao_Paulo');

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
    $servico = $item['servico'];
    $data_serv = $item['data_serv'];
    $cidade = $item['cidade'];
    $estado = $item['estado'];
    $endereco = $item['endereco'];
    $forma_pagamento = $item['forma_pagamento'];
    $espaco_mesa = $item['espaco_mesa']; // Adiciona a mesa selecionada
    $valor = $item['valor'];
    $data_insercao = date('Y-m-d H:i:s');

    $sql = "INSERT INTO carrinho (usuario_id, servico_id, nome, cnpj, telefone, servico, data_serv, cidade, estado, endereco, forma_pagamento, espaco_mesa, valor, data_insercao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("isssssssssssds", $user_id, $servico_id, $nome, $cnpj, $telefone, $servico, $data_serv, $cidade, $estado, $endereco, $forma_pagamento, $espaco_mesa, $valor, $data_insercao);
    $stmt->execute();
}

$response = ['status' => 'success'];
echo json_encode($response);
?>
