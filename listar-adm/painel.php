
<?php

    session_start();
        include_once('conexao.php');


        //print_r($_SESSION);
        if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
        {
            unset($_SESSION['nome']);
            unset($_SESSION['senha']);
            header('Location: index.php');
        }
        $logado = $_SESSION['nome'];

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Pricipal</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color:#000066;; 
            /*text-align: center;*/
        }
        .btn{
        color:white ;
        padding: 5px;
        text-decoration: none;
        
        }
        button{
            border-radius: 5px;
            text-decoration: none;
            border: none;
            padding: 15px;
            background-image: linear-gradient(to right,rgb(130, 20, 220), rgb(44, 31, 220));

        }
        .box{
            columns: 3;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 30px;
            width: 50%;
            right: 0%;
            color: white;
            
            
        }

        .box {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .box button {
            margin: 0 10px; /* Ajuste este valor conforme necessário */
        }

    </style>
</head>
<body>
    <div class="box">
    <button><a href="http://localhost/teste-usuario2/listar-adm/listar-serv.php"class="btn btn-danger me-5">Produtos</a></button>

    <button><a href="http://localhost/teste-usuario2/listar-adm/listar-vendas.php" class="btn btn-danger me-5">vendas</a></button>

    <button><a href="http://localhost/teste-usuario2/listar-adm/relatorio-geral.php" class="btn btn-danger me-5">Relatórios</a></button>

    <button><a href="http://localhost/phpmyadmin/index.php" class="btn btn-danger me-5">Editar esteque</a></button>

    <button><a href="sair.php" class="btn btn-danger me-5">Sair</a></button>
    </div>
</body>
</html>