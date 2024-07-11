<?php
  session_start();
  include_once('conexao.php');
  
  if (!isset($_SESSION['nome']) || !isset($_SESSION['senha'])) {
      unset($_SESSION['nome']);
      unset($_SESSION['senha']);
      header('Location: index.php');
      exit;
  }
  
  $logado = $_SESSION['nome'];
  
  if (!isset($_SESSION['user_id'])) {
      header('Location: login.php');
      exit;
  }
  
  $data_consulta = isset($_GET['data_consulta']) ? $_GET['data_consulta'] : date('Y-m-d');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $valor_sangria = floatval($_POST['valor_sangria']);
      $usuario_id = intval($_POST['usuario_id']); // Adicione este campo ao formulário para permitir a inserção para qualquer usuário
  
      // Inserir a sangria na tabela de sangrias
      $sql_insert = "INSERT INTO sangrias (usuario_id, valor_sangria, data_sangria) VALUES (?, ?, NOW())";
      $stmt_insert = $conexao->prepare($sql_insert);
      $stmt_insert->bind_param("id", $usuario_id, $valor_sangria);
      $stmt_insert->execute();
  
      echo "<p>Sangria de R$ " . number_format($valor_sangria, 2, ',', '.') . " registrada com sucesso.</p>";
      header('Location: ver_sangrias.php');
  }
  
  // Consulta os dados de todos os usuários e da data selecionada
  $sql = "SELECT * FROM sangrias WHERE DATE(data_sangria) = ? ORDER BY id DESC";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("s", $data_consulta);
  $stmt->execute();
  $result = $stmt->get_result();
  
  // Calcular a soma dos valores de sangria para todos os usuários
  $sql_sum = "SELECT SUM(valor_sangria) AS total_sangria FROM sangrias WHERE DATE(data_sangria) = ?";
  $stmt_sum = $conexao->prepare($sql_sum);
  $stmt_sum->bind_param("s", $data_consulta);
  $stmt_sum->execute();
  $result_sum = $stmt_sum->get_result();
  $total_sangria = $result_sum->fetch_assoc()['total_sangria'];
  
  // Calcular o valor total do carrinho considerando apenas pagamentos em dinheiro para todos os usuários
  $sql_cart = "SELECT SUM(valor) AS total_carrinho FROM carrinho WHERE DATE(data_insercao) = ? AND forma_pagamento = 'dinheiro'";
  $stmt_cart = $conexao->prepare($sql_cart);
  $stmt_cart->bind_param("s", $data_consulta);
  $stmt_cart->execute();
  $result_cart = $stmt_cart->get_result();
  $total_carrinho = $result_cart->fetch_assoc()['total_carrinho'];
  
  // Calcular a diferença entre o total do carrinho e o total da sangria
  $diferenca = $total_carrinho - $total_sangria;

  // Consulta os totais de sangria e dinheiro por usuário
    $sql_totals = "
    SELECT
        s.usuario_id,
        u.nome AS usuario_nome,
        SUM(s.valor_sangria) AS total_sangria,
        (SELECT SUM(c.valor) FROM carrinho c WHERE c.usuario_id = s.usuario_id AND DATE(c.data_insercao) = ? AND c.forma_pagamento = 'dinheiro') AS total_carrinho
    FROM
        sangrias s
    LEFT JOIN
        usuarios u ON s.usuario_id = u.id
    WHERE
        DATE(s.data_sangria) = ?
    GROUP BY
        s.usuario_id, u.nome";
    $stmt_totals = $conexao->prepare($sql_totals);
    $stmt_totals->bind_param("ss", $data_consulta, $data_consulta);
    $stmt_totals->execute();
    $result_totals = $stmt_totals->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Sangria</title>
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
            font-size:30px
        }

        th {
            background-color: #f2f2f2;
            font-size:30px
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
            background-color: rgb(21, 4, 98);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            position: fixed;
            width: 1455px;
            margin-left: 20px;
            margin-top: -19px;
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
            /*border: 1px solid black;*/
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
            width: 97.5%;
            margin-top: -10px;;
            margin-left: 10px;
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
        .btn-abrir{
            color: white;
            font-size: 20px;
            border:solid 1px;
            padding: 3px;;
            text-decoration: none;
        }
        .btn-abrir:active{
            color: red; /* Substitua 'red' pela cor desejada */
            background-color: yellow; /* Opcional: Substitua 'yellow' pela cor de fundo desejada ao clicar */
            border-color: blue; /* Opcional: Substitua 'blue' pela cor de borda desejada ao clicar */
            border-width: 3px; /* Aumente a largura da borda para 3px */
        }
        .btn-abrir:hover{
            background-color: yellow;
            color: red;
        }
        .btn-b{
            color: white;
            font-size: 20px;
            border:solid 1px;
            padding: 3px;;
        }
        .btn-b.clicked {
            color: black; /* Substitua 'red' pela cor desejada */
            background-color: yellow; /* Opcional: Substitua 'yellow' pela cor de fundo desejada ao clicar */
            border-color: blue; /* Opcional: Substitua 'blue' pela cor de borda desejada ao clicar */
            border-width: 3px; /* Aumente a largura da borda para 3px */
        }
        .btn-b:hover{
            background-color: black;
            color: red;
        }
        h2{
            color:white;
        }
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 16px;
            }

            th, td {
                font-size: 16px;
            }

            header {
                flex-direction: column;
                align-items: flex-start;
                margin-left: 5px;
            }

            .btn-abrir, .btn-b {
                font-size: 18px;
            }

            nav {
                width: 200px;
            }

            nav a {
                font-size: 20px;
            }
            div{
                margin-top: 100px;
                margin-left: 5px;
            }
        }

        @media (max-width: 400px) {
            table {
                width: 100%;
                font-size: 10px;
            }

            th, td {
                font-size: 10px;
            }

            .btn-abrir, .btn-b {
                font-size: 16px;
            }

            nav {
                width: 150px;
            }

            nav a {
                font-size: 18px;
            }
            div{
                margin-top: 110px;
                margin-left: 2px;
            }
             input{
            color:white;
        }
        .m-5{
                margin-top: 110px;
                margin-left: -12px;
                 width: 310px;
            }
        }
       

    </style>
</head>
<body>

    <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>

        <a href="sangrias copy.php" class="btn-b">Sangrias</a>

        <a href="relatorio_vendas_por_servico copy.php"class="btn-b">Relatório por itens</a>

        <a href="relatorio-periodo.php"class="btn-b">relatorio por período</a>

        <a href="relatorio-diario.php"class="btn-b">relatorio de Valores Diario</a>

        <a href="relatorio-geral.php"class="btn-b">relatorio Geral</a>
    </header>
   
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="painel.php">Voltar</a>
        
       <!-- <a href="listauser.php">Carrinho</a>-->
       
        <a href="sair.php">Sair</a>
        
        <!--<a href="relatorio_vendas_por_servico.php">Relatório por itens</a>-->
    </nav>

    <h1>Relatório de Sangrias</h1>
    <!--  
        <form method="post" action="sangrias.php">
            <label for="valor_sangria">Valor da Sangria:</label>
            <input type="number" id="valor_sangria" name="valor_sangria" step="0.01" required>
            <button type="submit">Registrar Sangria</button>
        </form>
    -->

    <main id="conteudo">
       
        <div class="m-5">
            <br>
            <form method="get" action="">
                <label for="data_consulta">Selecionar Data:</label>
                <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                <button type="submit">Consultar</button>
            </form>
            
        <!--    <label for="filtroNome">Filtrar por serviços:</label>
            <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">

            
            <label for="filtroData"><b>Data de Serviço</b></label>
            <input type="date" id="filtroData" onchange="filtrarPorData()">
        -->
            
            <table id="clientesTabela" class="box">
            
                <!--<thead>
                    <tr class="table">
                        <th scope="col">id</th>
                        <th scope="col">user_id</th>
                        <th scope="col">usuario_id</th>
                        <th scope="col">valor_sangria</th>
                        <th scope="col">data_sangria</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody class="box">
                    <?php
                    while ($user_data = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['usuario_id']."</td>";
                        echo "<td>".$user_data['valor_sangria']."</td>";
                        echo "<td>".$user_data['valor_sangria']."</td>";
                        echo "<td>".$user_data['data_sangria']."</td>";
                        //echo "<td></td>";
                        echo "</tr>"; // Fechar a linha da tabela
                    }
                    ?>-->
                </tbody>
            
                <tfoot>
                    <tr>
                        <th colspan="2">Total Sangria</th>
                        <th colspan="2"><?php echo number_format($total_sangria, 2, ',', '.'); ?></th>
                    </tr>
                    <tr>
                        <th colspan="2">Total Dinheiro</th>
                        <th colspan="2"><?php echo number_format($total_carrinho, 2, ',', '.'); ?></th>
                    </tr>
                    <tr>
                        <th colspan="2">Diferença</th>
                        <th colspan="2"><?php echo number_format($diferenca, 2, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
            <br>
            <h2>Totais por Usuário </h2>
            <table id="totalsTabela" class="box">
                <thead>
                    <tr class="table">
                        <th scope="col">Usuário ID</th>
                        <th scope="col">Nome do Usuário</th>
                        <th scope="col">Total Sangria</th>
                        <th scope="col">Total Dinheiro</th>
                        <th scope="col">Diferença</th>
                    </tr>
                </thead>
                <tbody class="box">
                    <?php
                    while ($totals_data = $result_totals->fetch_assoc()) {
                        $diferenca = $totals_data['total_carrinho'] - $totals_data['total_sangria'];
                        echo "<tr>";
                        echo "<td>".$totals_data['usuario_id']."</td>";
                        echo "<td>".$totals_data['usuario_nome']."</td>";
                        echo "<td>".number_format($totals_data['total_sangria'], 2, ',', '.')."</td>";
                        echo "<td>".number_format($totals_data['total_carrinho'], 2, ',', '.')."</td>";
                        echo "<td>".number_format($diferenca, 2, ',', '.')."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Verifica o estado do botão no localStorage
            var isClicked = localStorage.getItem("btn-b-clicked");
            if (isClicked === "true") {
                document.querySelector(".btn-b").classList.add("clicked");
            }

            // Adiciona o evento de clique ao botão
            document.querySelector(".btn-b").addEventListener("click", function() {
                this.classList.add("clicked");
                localStorage.setItem("btn-b-clicked", "true");
            });
        });

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




