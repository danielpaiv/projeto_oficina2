<?php
    session_start();
    include_once('conexao.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $data_consulta = isset($_GET['data_consulta']) ? $_GET['data_consulta'] : date('Y-m-d', strtotime('-1 day'));

    // Consulta para obter os totais de serviços por data específica
    $sql = "SELECT usuario_id, 
                servico,
                SUM(valor) AS total_valor,
                COUNT(*) AS total_quantidade 
            FROM carrinho 
            WHERE usuario_id = ? AND DATE(data_insercao) = ?
            GROUP BY usuario_id, servico";

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
    <title>Menu lateral</title>
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
        <a href="meuRelatorio.php">Relatorio por administradora</a>
    </nav>

    <main id="conteudo">

        <div class="center">

            <section>
                <h1>Relatório de Vendas por Itens</h1>
                
                <form method="get" action="">
                    <label for="data_consulta">Selecionar Data:</label>
                    <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                    <button type="submit">Consultar</button>
                </form>

                <table border="1">
                    <thead>
                        <tr>
                            <th>Usuário ID</th>
                            <th>Serviço</th>
                            <th>Total Valor</th>
                            <th>Total Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['usuario_id'] . "</td>";
                            echo "<td>" . $row['servico'] . "</td>";
                            echo "<td>" . $row['total_valor'] . "</td>";
                            echo "<td>" . $row['total_quantidade'] . "</td>";
                            echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
       
            </section>

        </div>

    </main>
    
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


















