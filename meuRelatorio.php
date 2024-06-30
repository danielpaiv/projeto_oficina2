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

    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php'); // Redireciona para a página de login se não estiver logado
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $data_consulta = isset($_GET['data_consulta']) ? $_GET['data_consulta'] : date('Y-m-d', strtotime('-1 day'));
    //$data_atual = date('Y-m-d');
    // Consulta para obter a soma dos valores e quantidades apenas do usuário atual
    //$sql = "SELECT usuario_id, SUM(valor) AS total_valor, COUNT(*) AS total_quantidade FROM carrinho WHERE usuario_id = ? AND DATE(data_insercao) = ? GROUP BY usuario_id";

    $sql = "SELECT usuario_id, 
                SUM(CASE WHEN forma_pagamento = 'debito' THEN valor ELSE 0 END) AS total_debito,
                SUM(CASE WHEN forma_pagamento = 'credito' THEN valor ELSE 0 END) AS total_credito,
                SUM(CASE WHEN forma_pagamento = 'dinheiro' THEN valor ELSE 0 END) AS total_dinheiro,
                SUM(CASE WHEN forma_pagamento = 'pix' THEN valor ELSE 0 END) AS total_pix,
                SUM(valor) AS total_valor,
                COUNT(*) AS total_quantidade 
                
            FROM carrinho 
            WHERE usuario_id = ?  AND DATE(data_insercao) = ?
            GROUP BY usuario_id";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("is", $user_id, $data_consulta);
    $stmt->execute();
    $result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Relatório</title>
     <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:#313b73ff;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
        a{
            text-decoration: none;
        }
        header{
            background-color: rgb(21, 4, 98  );
            padding: 10px;
        }
        .btn-abrir{
            color: white;
            font-size: 20px;
        }
        nav{
            height: 0%;
            width: 250px;
            background-color: rgb(21, 4, 98  ) ;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            overflow: hidden;
            transition: width 0.3s;
        }
        nav a{
            color: white;
            font-size: 25px;
            display: block;
            padding: 12px 10px 12px 32px;
        }
        nav a:hover{
            color: rgb(21, 4, 98  );
            background-color: white;
        }
        main{
            padding: 10px;
            transition: margin-left 0.5s;
        }
        table,th,td{
            border: 1px solid black;
            border-collapse:collapse ;
        }
        th,td{
            padding: 5px 10px;
        }
        th{
            background-color: rgb(21, 4, 98);
            color: white;
        }
        /*odd aplicado em todos elementos inpares*/
        table tr:nth-child(odd){
            background-color: #ddd;

        }
        /*odd aplicado em todos elementos pares*/
        table tr:nth-child(even){
            background-color:white ;

        }
        div{
            display: inline-block;
            background-color: #060642 ;
            padding: 5px;
            text-align: center;
            width: 99%;
        }
        legend{
            color: white;
        }
        h3{
            color: blue;
        }
        p{
            color: white;
        }
        label{
            color:white;
        }

    </style>
</head>
<body>
   

        <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>

    </header>
   
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="vendas.php">Vendas</a>
        <a href="listauser.php">Carrinho</a>
        <a href="sair.php">Sair</a>
        <a href="relatorio_vendas_por_servico.php">Relatório por itens</a>
    </nav>

    <main id="conteudo">

 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
</head>
<body>
    <main id="conteudo">
        <div class="center">
            <div>
                <section>

                    <h1>Relatório por administradora</h1>

                    <form method="get" action="">
                    <label for="data_consulta">Selecionar Data:</label>
                    <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                    <button type="submit">Consultar</button>
                </form>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Usuário ID</th>
                                <th>Total Débito</th>
                                <th>Total Crédito</th>
                                <th>Total Dinheiro</th>
                                <th>Total Pix</th>
                                <th>Total Valor</th>
                                <th>Total Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['usuario_id'] . "</td>";
                                echo "<td>" . $row['total_debito'] . "</td>";
                                echo "<td>" . $row['total_credito'] . "</td>";
                                echo "<td>" . $row['total_dinheiro'] . "</td>";
                                echo "<td>" . $row['total_pix'] . "</td>";
                                echo "<td>" . $row['total_valor'] . "</td>";
                                echo "<td>" . $row['total_quantidade'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    
                    </table>

                </section>
            </div>

        </div>

        
       
    </main>
</body>
</html>

    
    
    <script>
        function abrirMenu() {
            document.getElementById('menu').style. height = '100%';
            document.getElementById('conteudo').style.marginLeft = '15%';
        }
        function facharMenu(){
            document.getElementById('menu').style. height = '0%'
            document.getElementById('conteudo').style.marginLeft = '0%';
        }
        
    </script>

</body>
</html>


