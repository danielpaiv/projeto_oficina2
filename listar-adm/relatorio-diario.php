<?php
     session_start();
     include_once('conexao.php');
 
     // Verifica se o usuário está logado
     if ((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true)) {
         unset($_SESSION['nome']);
         unset($_SESSION['senha']);
         header('Location: index.php');
     }
     $logado = $_SESSION['nome'];
 
     // Obtém a data da consulta ou usa a data do dia anterior por padrão
     $data_consulta = isset($_GET['data_consulta']) ? $_GET['data_consulta'] : date('Y-m-d');
 
     // Consulta para obter a soma dos valores e quantidades de cada usuário por data específica
     $sql = "SELECT c.usuario_id, u.nome,
             SUM(CASE WHEN forma_pagamento = 'debito' THEN valor ELSE 0 END) AS total_debito,
             SUM(CASE WHEN forma_pagamento = 'credito' THEN valor ELSE 0 END) AS total_credito,
             SUM(CASE WHEN forma_pagamento = 'dinheiro' THEN valor ELSE 0 END) AS total_dinheiro,
             SUM(CASE WHEN forma_pagamento = 'pix' THEN valor ELSE 0 END) AS total_pix,
             SUM(c.valor) AS total_valor,
             COUNT(*) AS total_quantidade 
             FROM carrinho c
             JOIN usuarios u ON c.usuario_id = u.id
             WHERE DATE(c.data_insercao) = ?
             GROUP BY c.usuario_id";
     $stmt = $conexao->prepare($sql);
     $stmt->bind_param("s", $data_consulta);
     $stmt->execute();
     $result = $stmt->get_result();
 
     // Consulta para obter o total geral de valores e quantidades para a data específica
     $sql_total_geral = "SELECT SUM(CASE WHEN forma_pagamento = 'debito' THEN valor ELSE 0 END) AS total_geral_debito,
                               SUM(CASE WHEN forma_pagamento = 'credito' THEN valor ELSE 0 END) AS total_geral_credito,
                               SUM(CASE WHEN forma_pagamento = 'dinheiro' THEN valor ELSE 0 END) AS total_geral_dinheiro,
                               SUM(CASE WHEN forma_pagamento = 'pix' THEN valor ELSE 0 END) AS total_geral_pix,
                               SUM(c.valor) AS total_geral_valor,
                               COUNT(*) AS total_geral_quantidade 
                        FROM carrinho c
                        WHERE DATE(c.data_insercao) = ?";
     $stmt_total = $conexao->prepare($sql_total_geral);
     $stmt_total->bind_param("s", $data_consulta);
     $stmt_total->execute();
     $result_total = $stmt_total->get_result();
     $total_geral = $result_total->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Valores</title>
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
            width: 70%;
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
            background-color: rgb(21, 4, 98);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            position: fixed;
             width: 1455px;
            margin-left: 20px;
            margin-top: 1px;;
        }
        .btn-abrir{
            color: white;
            font-size: 20px;
            border:solid 1px;
            padding: 3px;;
        }
        .btn-abrir:active {
            color: red; /* Substitua 'red' pela cor desejada */
            background-color: yellow; /* Opcional: Substitua 'yellow' pela cor de fundo desejada ao clicar */
            border-color: blue ; /* Opcional: Substitua 'blue' pela cor de borda desejada ao clicar */
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
            width: 97.5%;
            margin-top: 70px;;
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
        .hidden {
            display: none;
            
        }

        #options a {
            display: block;
            margin: 5px 0;
        }
        label{
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
                columns:3;
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
                width: 0%;
                font-size: 6px;
            }

            th, td {
                font-size: 6px;
            }
            header {
                flex-direction: column;
                align-items: flex-start;
                margin-left: 0px;
                
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
                margin-top: 100px;
                margin-left: 0px;
            }
            input{
                color:white;
            }
            .box{
                margin-top: 210px;
                margin-left: -18px;
                 width: 350px;
            }
            .center{
                margin-top: 100px;
                
            }
        }
    </style>
   
</head>
<body>

    <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>

        <a href="relatorio-diario.php"class="btn-b">relatorio de Valores Diario</a>

        <a href="relatorio-periodo.php"class="btn-b">relatorio por período</a>

        <a href="relatorio-geral.php"class="btn-b">Relatorio de Valores Geral</a>

        <a href="relatorio_vendas_por_servico copy.php"class="btn-b">Relatório por itens</a>

        <a href="sangrias copy.php" class="btn-b">Sangrias</a>

        <a href="fundo_caixa.php"class="btn-b">Fundo de caixa</a>

        <a href="https://lightcoral-cassowary-439946.hostingersite.com/listar-adm/graficos/graficos_geral.php"class="btn-b">Graficos</a>

        

    </header>
   
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="painel.php">Voltar</a>
        <a href="http://localhost/projeto_oficina/adm/index.php">Cadastrar User</a>
        <!--
            <a href="relatorio-periodo.php">relatorio por período</a>
            <a href="relatorio-geral.php">relatorio Geral</a>
            <a href="relatorio_vendas_por_servico copy.php">Relatório por itens</a>
            <a href="#">Mais opções</a>
        
        <a href="#" id="showOptions">Mais opções</a>
        <div id="options" class="hidden">
            
            <a href="#">Menu User</a>
            
            <a href="#">Cadastrar um Produto</a>
            
            <a href="Sair.php">Sair</a>
            
            <a href="#"></a>
            <a href="#"></a>-->
        </div>
    </nav>

    <main id="conteudo">

            
                

                <div class="box">

                    <section>

                    <label for="filtroNome">Filtrar por nome do usuario:</label>
                    <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">

                        <h1>Relatório de Valores Diário</h1>
                        <form method="get" action="">
                            <label for="data_consulta">Selecionar Data:</label>
                            <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                            <button type="submit">Consultar</button>
                        </form>
                        <table id="clientesTabela" border="1">
                            <thead>
                                <tr>
                                    <th>Usuário ID</th>
                                    <th>Nome do Usuário</th>
                                    
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
                                    echo "<td>" . $row['nome'] . "</td>";
                                   
                                    echo "<td>" . $row['total_debito'] . "</td>";
                                    echo "<td>" . $row['total_credito'] . "</td>";
                                    echo "<td>" . $row['total_dinheiro'] . "</td>";
                                    echo "<td>" . $row['total_pix'] . "</td>";
                                    echo "<td>" . $row['total_valor'] . "</td>";
                                    echo "<td>" . $row['total_quantidade'] . "</td>";
                                    echo "</tr>";
                                }

                                    // Exibir total geral ao final da tabela
                                    echo "<tr>";
                                    echo "<td colspan='2'><strong>Total Geral</strong></td>";
                                    echo "<td><strong>" . $total_geral['total_geral_debito'] . "</strong></td>";
                                    echo "<td><strong>" . $total_geral['total_geral_credito'] . "</strong></td>";
                                    echo "<td><strong>" . $total_geral['total_geral_dinheiro'] . "</strong></td>";
                                    echo "<td><strong>" . $total_geral['total_geral_pix'] . "</strong></td>";
                                    echo "<td><strong>" . $total_geral['total_geral_valor'] . "</strong></td>";
                                    echo "<td><strong>" . $total_geral['total_geral_quantidade'] . "</strong></td>";
                                    echo "</tr>";
                                ?>
                            </tbody>
                        </table>
        
                    </section>

            </div>

    </main>
    
    <script>

        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[1]; // coluna "Nome"
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

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

        document.getElementById('showOptions').addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link
            var options = document.getElementById('options');
            if (options.classList.contains('hidden')) {
                options.classList.remove('hidden');
            } else {
                options.classList.add('hidden');
            }
        });

        function abrirMenu() {
            document.getElementById('menu').style. height = '100%';
            document.getElementById('conteudo').style.marginLeft = '17%';
        }
        function facharMenu(){
            document.getElementById('menu').style. height = '0%'
            document.getElementById('conteudo').style.marginLeft = '0%';
        }
        
    </script>

</body>
</html>



