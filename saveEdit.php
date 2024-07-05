<?php

    session_start();
    include_once('config.php');

    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php'); // Redireciona para a página de login se não estiver logado
        exit;
    }

    //print_r($_SESSION);
    if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['nome']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    }
    $logado = $_SESSION['nome'];
    $user_id = $_SESSION['user_id'];

    include_once('config.php');

    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cnpj = $_POST['cnpj'];
        $telefone = $_POST['telefone'];
        $servico = $_POST['servico'];
        $data_serv = $_POST['data_serv'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];
        $forma_pagamento = $_POST['forma_pagamento'];
       // $valor = $_POST['valor'];
        $user_id = $_POST['user_id']; // Obtém o ID do usuário da sessão

        $sqlUpdate = "UPDATE clientes SET nome='$nome', cnpj='$cnpj', telefone='$telefone', cidade='$cidade', estado='$estado', endereco='$endereco', forma_pagamento='$forma_pagamento', user_id='$user_id'
        WHERE id='$id'";

        $result = $conexao->query($sqlUpdate); 

        header('Location: listauser.php');



        

    }


?>