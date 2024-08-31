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
    $canal_venda = $item['canal_venda']; // Adiciona o canal de venda
    $valor = $item['valor'];
    $data_insercao = date('Y-m-d H:i:s');

    // Atualiza a query para incluir o campo canal_venda
    $sql = "INSERT INTO carrinho (usuario_id, servico_id, nome, cnpj, telefone, servico, data_serv, cidade, estado, endereco, forma_pagamento, espaco_mesa, canal_venda, valor, data_insercao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    
    // Certifique-se de usar "s" para strings, incluindo canal_venda
    $stmt->bind_param("issssssssssssds", $user_id, $servico_id, $nome, $cnpj, $telefone, $servico, $data_serv, $cidade, $estado, $endereco, $forma_pagamento, $espaco_mesa, $canal_venda, $valor, $data_insercao);
    
    $stmt->execute();
}

$response = ['status' => 'success'];
echo json_encode($response);
?>
