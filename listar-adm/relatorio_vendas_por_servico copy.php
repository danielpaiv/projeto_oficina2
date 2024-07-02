<?php
    session_start();
    include_once('conexao.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    //, strtotime('-1 day')
    $data_consulta = isset($_GET['data_consulta']) ? $_GET['data_consulta'] : date('Y-m-d');
    $nome_usuario = isset($_GET['nome_usuario']) ? $_GET['nome_usuario'] : '';

    $sql = "SELECT c.usuario_id, u.nome, c.servico, 
            SUM(c.valor) AS total_valor, 
            COUNT(*) AS total_quantidade 
            FROM carrinho c
            JOIN usuarios u ON c.usuario_id = u.id
            WHERE DATE(c.data_insercao) = ?
            AND u.nome LIKE ?
            GROUP BY c.usuario_id, u.nome, c.servico";

    $stmt = $conexao->prepare($sql);
    $nome_usuario_like = '%' . $nome_usuario . '%';
    $stmt->bind_param("ss", $data_consulta, $nome_usuario_like);
    $stmt->execute();
    $result = $stmt->get_result();

    $sql_totals = "SELECT c.usuario_id, u.nome, SUM(c.valor) AS total_valor, COUNT(*) AS total_quantidade 
                FROM carrinho c
                JOIN usuarios u ON c.usuario_id = u.id
                WHERE DATE(c.data_insercao) = ?
                AND u.nome LIKE ?
                GROUP BY c.usuario_id, u.nome";

    $stmt_totals = $conexao->prepare($sql_totals);
    $stmt_totals->bind_param("ss", $data_consulta, $nome_usuario_like);
    $stmt_totals->execute();
    $result_totals = $stmt_totals->get_result();
?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio de vendas</title>
     <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #313b73ff;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        .table-container {
            width: 60%;  /* Increase width to make table larger */
            margin: 20px auto;
        }

        table {
            width: 130%;  /* Table takes full width of the container */
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

        a {
            text-decoration: none;
        }

        header {
            background-color: rgb(21, 4, 98);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            position: fixed;
            width: 1625px;
            margin-left: 20px;
            margin-top: 0px;
            
            
        }

        .btn-abrir {
            color: white;
            font-size: 20px;
            border:solid 1px;
            padding: 3px;;
        }
         .btn-abrir:active {
            color: red; /*Substitua 'red' pela cor desejada */
            background-color: yellow; /* Opcional: Substitua 'yellow' pela cor de fundo desejada ao clicar */
            border-color: blue; /* Opcional: Substitua 'blue' pela cor de borda desejada ao clicar */
            border-width: 3px; /* Aumente a largura da borda para 3px*/
             
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

        nav {
            height: 0%;
            width: 250px;
            background-color: rgb(21, 4, 98);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            overflow: hidden;
            transition: width 0.3s;
        }

        nav a {
            color: white;
            font-size: 25px;
            display: block;
            padding: 12px 10px 12px 32px;
        }

        nav a:hover {
            color: rgb(21, 4, 98);
            background-color: white;
        }

        main {
            padding: 10px;
            transition: margin-left 0.5s;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px 10px;
        }

        th {
            background-color: rgb(21, 4, 98);
            color: white;
        }

        table tr:nth-child(odd) {
            background-color: #ddd;
        }

        table tr:nth-child(even) {
            background-color: white;
        }

        .report-container {
            display: flex;
            justify-content: space-between; /* Adjust spacing to give more room */
        }

        .report-container > div {
            width: 38%; /* Adjust width of each section to balance the space */
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
        div{
            display: inline-block;
            background-color: #060642 ;
            padding: 20px;
            text-align: center;
            width: 96%;
            margin-top: 70px;
            margin-left: 10px;
        }
        
    </style>
</head>
<body>
   

    <header>
        <!--criei uma class para usar no css e não ter conflito com outros links-->
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>

        <a href="relatorio_vendas_por_servico copy.php"class="btn-b">Relatório por itens</a>

        <a href="relatorio-periodo.php"class="btn-b">relatorio por período</a>

        <a href="relatorio-diario.php"class="btn-b">relatorio Diario</a>

        <a href="relatorio-geral.php"class="btn-b">relatorio Geral</a>

        <a href="http://localhost/teste-usuario2/listar-adm/graficos/graficos_geral.php#"class="btn-b">Graficos</a>

    </header>
   
    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>

        <a href="http://localhost/teste-usuario2/listar-adm/painel.php">Voltar</a>

        <a href="http://localhost/teste-usuario2/adm/index.php">Cadastrar User</a>
        <!--
            <a href="relatorio-periodo.php">relatorio por período</a>
            <a href="relatorio-diario.php">relatorio Diario</a>
            <a href="relatorio_vendas_por_servico copy.php">Relatório por itens</a>
            <a href="#">Mais opções</a>
        -->
        <a href="#" id="showOptions">Mais opções</a>
        <div id="options" class="hidden">

            <a href="http://localhost/teste-usuario2/index.php">Menu User</a>

            <a href="http://localhost/teste-usuario2/adm/formulario_copy.php">Cadastrar um Produto</a>

            <a href="Sair.php">Sair</a>

            <a href="#"></a>
        </div>
    </nav>

    <main id="conteudo">

        <div class="report-container">

            <section>
                <h1>Relatório de Vendas por Itens</h1>

                <!--
                    <form method="get" action="">
                        <label for="data_consulta">Selecionar Data:</label>
                        <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                        <label for="nome_usuario">Nome do Usuário:</label>
                        <input type="text" id="nome_usuario" name="nome_usuario" value="<?php echo htmlspecialchars($nome_usuario); ?>">
                        <button type="submit">Consultar</button>
                    </form>
                -->
                    
                    <form method="get" action="">
                        <label for="data_consulta">Selecionar Data:</label>
                        <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">
                        <button type="submit">Consultar</button>
                    </form>
                    <br>
                    <label for="filtroNome">Filtrar por Usuário:</label>
                    <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">
                    <br><br>
                    <form method="post" action="exibir_relatorio.php" target="_blank">
                    <input type="hidden" name="data_consulta" value="<?php echo $data_consulta; ?>">
                    <button type="submit">Gerar Relatório</button>
                </form>
                <br>
                <br><br>

                <table id="clientesTabela" border="1">
                    <thead>
                        <tr>
                            <th>Usuário ID</th>
                            <th>Nome do Usuário</th>
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
                            echo "<td>" . $row['nome'] . "</td>";
                            echo "<td>" . $row['servico'] . "</td>";
                            echo "<td>" . $row['total_valor'] . "</td>";
                            echo "<td>" . $row['total_quantidade'] . "</td>";
                            echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
       
            </section>

            <div>
                <section>
                    <h1>Totais por Usuário</h1>
                    <br>
                    <div class="table-container">
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Usuário ID</th>
                                    <th>Nome do Usuário</th>
                                    <th>Total Valor</th>
                                    <th>Total Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_totals = $result_totals->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row_totals['usuario_id'] . "</td>";
                                    echo "<td>" . $row_totals['nome'] . "</td>";
                                    echo "<td>" . $row_totals['total_valor'] . "</td>";
                                    echo "<td>" . $row_totals['total_quantidade'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

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
            document.getElementById('conteudo').style.marginLeft = '15%';
        }
        function facharMenu(){
            document.getElementById('menu').style. height = '0%'
            document.getElementById('conteudo').style.marginLeft = '0%';
        }

        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[2]; // coluna "Nome"
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
        
    </script>

</body>
</html>


















