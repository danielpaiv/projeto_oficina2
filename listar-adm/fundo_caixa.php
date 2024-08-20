<?php
// Configurações do banco de dados
$host = 'localhost'; // Alterar conforme necessário
$dbname = 'servicos_oficina'; // Alterar conforme necessário
$username = 'root'; // Alterar conforme necessário
$password = ''; // Alterar conforme necessário

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit();
}

// Inicializa as variáveis de data
$dataInicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
$dataFim = isset($_POST['data_fim']) ? $_POST['data_fim'] : '';

// Valida as datas
if ($dataInicio && $dataFim) {
    $dataInicio = date('Y-m-d', strtotime($dataInicio));
    $dataFim = date('Y-m-d', strtotime($dataFim));
} else {
    // Define um intervalo padrão se as datas não forem fornecidas
    $dataInicio = date('Y-m-d', strtotime('-1 month'));
    $dataFim = date('Y-m-d');
}

// Consulta para obter a soma dos valores da tabela carrinho dentro do intervalo de datas
$queryCarrinho = "SELECT SUM(valor) AS total_carrinho FROM carrinho WHERE data_insercao >= :dataInicio AND data_insercao <= :dataFim";
$stmtCarrinho = $pdo->prepare($queryCarrinho);
$stmtCarrinho->bindParam(':dataInicio', $dataInicio);
$stmtCarrinho->bindParam(':dataFim', $dataFim);
$stmtCarrinho->execute();
$resultCarrinho = $stmtCarrinho->fetch(PDO::FETCH_ASSOC);
$totalCarrinho = $resultCarrinho['total_carrinho'];

// Consulta para obter a soma dos valores da tabela despesas dentro do intervalo de datas
$queryDespesas = "SELECT SUM(valor) AS total_despesas FROM despesas WHERE data_insercao >= :dataInicio AND data_insercao <= :dataFim";
$stmtDespesas = $pdo->prepare($queryDespesas);
$stmtDespesas->bindParam(':dataInicio', $dataInicio);
$stmtDespesas->bindParam(':dataFim', $dataFim);
$stmtDespesas->execute();
$resultDespesas = $stmtDespesas->fetch(PDO::FETCH_ASSOC);
$totalDespesas = $resultDespesas['total_despesas'];

// Calcula o saldo
$saldo = $totalCarrinho - $totalDespesas;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundo de Caixa</title>
    <style>
         body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
            background-color: #313b73ff;

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
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            font-size:20px;
        }
        th, td {
            padding: 20px;
            text-align: center;
        }
        th {
            background-color: black;
        }
        h1{
            color:white;
        }
        label{
            color:white;
        }

        @media (max-width: 800px){

            div{
                width: 99%;
            }

            header {
            background-color: rgb(21, 4, 98);
            padding: 10px;
            width: 97%;
            }

            h2{
                color:white;
            }

            .tipos{
                color:white;
            }

            label{
                color:white;
            }

            th, td {
            padding: 5px 10px;
            font-size: 15px;
            }
            }

            @media (max-width: 400px){
            div{
                width: 98%;
            }

            header {
            background-color: rgb(21, 4, 98);
            padding: 10px;
            width: 95%;
            }

            h2{
                color:white;
            }

            .tipos{
                color:white;
            }

            label{
                color:white;
            }

            #conteudo{
                
            }

            th, td {
            padding: 5px 10px;
            font-size: 15px;
            }

            table {
                width: 80%;
            }
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
        <a href="listar_despesas.php">Lista de Despesas</a>
        <a href="relatorio-geral.php">Voltar</a>
        
    </nav>

    <main id="conteudo">

            <div>
            <h1>Resumo do Fundo de Caixa</h1>

            <form method="post" action="">
                <label for="data_inicio">Data Início:</label>
                <input type="date" id="data_inicio" name="data_inicio" value="<?php echo htmlspecialchars($dataInicio); ?>" required>
                <br><br>
                <label for="data_fim">Data Fim:</label>
                <input type="date" id="data_fim" name="data_fim" value="<?php echo htmlspecialchars($dataFim); ?>" required>
                <button type="submit">Filtrar</button>
            </form>
                <section>
                    
                    
    
                    <table>
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Faturamento</td>
                                <td>R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Despesas</td>
                                <td>R$ <?php echo number_format($totalDespesas, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Lucro</strong></td>
                                <td><strong>R$ <?php echo number_format($saldo, 2, ',', '.'); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
       
                </section>

             </div>

    </main>
    
    <script>
        function abrirMenu() {
            document.getElementById('menu').style. height = '100%';
            document.getElementById('conteudo').style.marginLeft = '20%';
        }
        function facharMenu(){
            document.getElementById('menu').style. height = '0%'
            document.getElementById('conteudo').style.marginLeft = '0%';
        }
        
    </script>
</body>
</html>


