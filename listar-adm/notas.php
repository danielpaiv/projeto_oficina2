<?php
    // Verifica se os dados da venda foram enviados
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Exemplo de como você pode acessar os dados enviados
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $usuario_id = $_POST['usuario_id'];
        $servico_id = $_POST['servico_id'];
        $nome = $_POST['nome'];
        $cnpj = $_POST['cnpj'];
        $telefone = $_POST['telefone'];
        $servico = $_POST['servico'];
        $data_serv = $_POST['data_serv'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];
        $forma_pagamento = $_POST['forma_pagamento'];
        $valor = $_POST['valor'];
        $data_insercao = $_POST['data_insercao'];
    } else {
        // Se os dados não foram enviados corretamente, redireciona de volta para a página anterior
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Fiscal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1,h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button{
            background-color:red;
            border:none;
            text-decoration:none;
        }
        a{
            font-size:15px;
            text-decoration:none;
        }
    </style>
</head>
<body>
    <button><a href="sair.php">sair</a></button>
    <button><a href="listar-vendas.php">Voltar</a></button>
    <br><br>
    <h1>Nota Fiscal</h1>
    <table>
        <tr>
            <th>ID</th>
            <td><?php echo $id; ?></td>
        </tr>
        <!--<tr>
            <th>User ID</th>
            <td><?php echo $user_id; ?></td>
        </tr>
        <tr>
            <th>Usuário ID</th>
            <td><?php echo $usuario_id; ?></td>
        </tr>
        <tr>
            <th>Serviço ID</th>
            <td><?php echo $servico_id; ?></td>
        </tr>-->
        <tr>
            <th>Cliente</th>
            <td><?php echo $nome; ?></td>
        </tr>
        <tr>
            <th>CNPJ</th>
            <td><?php echo $cnpj; ?></td>
        </tr>
        <tr>
            <th>Telefone</th>
            <td><?php echo $telefone; ?></td>
        </tr>
        <tr>
            <th>Serviço</th>
            <td><?php echo $servico; ?></td>
        </tr>
        <tr>
            <th>Data do Serviço</th>
            <td><?php echo $data_serv; ?></td>
        </tr>
        <tr>
            <th>Cidade</th>
            <td><?php echo $cidade; ?></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?php echo $estado; ?></td>
        </tr>
        <tr>
            <th>Endereço</th>
            <td><?php echo $endereco; ?></td>
        </tr>
        <tr>
            <th>Forma de Pagamento</th>
            <td><?php echo $forma_pagamento; ?></td>
        </tr>
        <tr>
            <th>Valor</th>
            <td><?php echo $valor; ?></td>
        </tr>
        <tr>
            <th>Data de Inserção</th>
            <td><?php echo $data_insercao; ?></td>
        </tr>

        
    </table>

    <h2>Dados da empresa</h2>
    <table>
        
        <tr>
            <th>Empresa</th>
            <td>ClaspSystems</td>
        </tr>
        <tr>
            <th>Cnpj</th>
            <td>40.912.304/0001-40</td>
        </tr>
        <tr>
            <th>Telefone</th>
            <td>(81) 99361-9196</td>
        </tr>
        <tr>
            <th>Endeço</th>
            <td>Rua José Martins Sobrinho</td>
        </tr>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Imprimir</button>
    </div>
</body>
</html>
