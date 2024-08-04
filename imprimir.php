<?php

date_default_timezone_set('America/Sao_Paulo');

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['valor_sangria']) && isset($_GET['usuario_id']) && isset($_GET['nome_usuario'])) {
        $valor_sangria = floatval($_GET['valor_sangria']);
        $usuario_id = intval($_GET['usuario_id']);
        $nome_usuario = htmlspecialchars($_GET['nome_usuario']);
        $data_sangria = date('d/m/Y H:i:s');
    } else {
        die("Dados da sangria não fornecidos.");
    }
    //header('Location: listauser.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Sangria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        header{
            background-color: rgb(21, 4, 98);
            padding: 15px;
        }
        .btn-abrir{
            color: white;
            font-size: 20px;
            border:solid 1px;
            padding: 3px;;
        }
        a{
            text-decoration:none;
        }
    </style>
</head>
<body>
    <header>
    <a href="meuRelatorio.php" class="btn-abrir">Voltar</a>
    </header>
    <div class="container">
        <h1>Dados da Sangria</h1>
        <p><strong>ID do Usuário:</strong> <?php echo $usuario_id; ?></p>
        <p><strong>Nome do Usuário:</strong> <?php echo $nome_usuario; ?></p>
        <p><strong>Valor da Sangria:</strong> R$ <?php echo number_format($valor_sangria, 2, ',', '.'); ?></p>
        <p><strong>Data da Sangria:</strong> <?php echo $data_sangria; ?></p>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
        //header('Location: listauser.php');
    </script>
</body>
</html>
