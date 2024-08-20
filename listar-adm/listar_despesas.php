<?php
session_start();
include_once('conexao.php');

// Verificação de sessão
if ((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
$logado = $_SESSION['nome'];

// Consulta para obter todas as despesas
$sql = "SELECT * FROM despesas ORDER BY id DESC";
$result = $conexao->query($sql);

// Consulta para obter totais por tipo de despesa
$sqlTotalPorTipo = "SELECT tipo_despesa_id, SUM(valor) AS total_por_tipo
                     FROM despesas
                     GROUP BY tipo_despesa_id";
$resultTotalPorTipo = $conexao->query($sqlTotalPorTipo);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar | Despesas</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background-color: #313b73ff;
        }
        a {
            text-decoration: none;
        }
        header {
            background-color: rgb(21, 4, 98);
            padding: 10px;
        }
        .btn-abrir {
            color: white;
            font-size: 20px;
        }
        nav {
            height: 0;
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
            display: flex;
            justify-content: space-between;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px 10px;
            font-size: 25px;
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
        div {
            display: inline-block;
            background-color: #060642;
            padding: 5px;
            text-align: center;
            width: 100%;
        }
        legend {
            color: white;
        }
        h3 {
            color: blue;
        }
        p {
            color: white;
        }
        .tables-container {
            display: flex;
            justify-content: space-between;
        }
        .tables-container > table {
            width: 65%;
        }

        label{
                color:white;
            }

        .tipos{
            color:white;
        }

        h2{
            color:white;
        }

        @media (max-width: 800px){

            div{
                width: 100%;
            }

            header {
            background-color: rgb(21, 4, 98);
            padding: 10px;
            width: 98%;
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
                width: 125%;
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
            font-size: 7px;
            }
        }

        
    </style>
</head>
<body>
    <header>
        <a href="#" class="btn-abrir" onclick="abrirMenu()">&#9776; Menu</a>
    </header>

    <nav id="menu">
        <a href="#" onclick="facharMenu()">&times; Fechar</a>
        <a href="fundo_caixa.php">Voltar</a>
        <!--<a href="#">Sobre</a>
        <a href="#">Contato</a>
        <a href="#">Mais opções</a>-->
    </nav>

    <main id="conteudo">
        <div class="tables-container">
            <section>
                <h2>Despesas</h2>

                <label for="filtroNome">Buscar por tipo:</label>
                <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">
                <br><br>


                <table id="despesasTabela" class="box">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">descricao</th>
                            <th scope="col">valor</th>
                            <th scope="col">data_insercao</th>
                            <th scope="col">tipo_despesa_id</th>
                        </tr>
                    </thead>
                    <tbody class="box">
                        <?php while ($user_data = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user_data['id']; ?></td>
                                <td><?php echo $user_data['descricao']; ?></td>
                                <td><?php echo number_format($user_data['valor'], 2, ',', '.'); ?></td>
                                <td><?php echo $user_data['data_insercao']; ?></td>
                                <td><?php echo $user_data['tipo_despesa_id']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>

            <section>
                <h2 class="tipos">Totais por Tipo de Despesa</h2>
                <table id="totaisPorTipo" class="box">
                    <thead>
                        <tr>
                            <th scope="col">Tipo de Despesa ID</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody class="box">
                        <?php while ($total_data = $resultTotalPorTipo->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $total_data['tipo_despesa_id']; ?></td>
                                <td><?php echo number_format($total_data['total_por_tipo'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>

    <script>

        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('despesasTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[4]; // coluna "Nome"
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
        function abrirMenu() {
            document.getElementById('menu').style.height = '100%';
            document.getElementById('conteudo').style.marginLeft = '20%';
        }
        function facharMenu() {
            document.getElementById('menu').style.height = '0%';
            document.getElementById('conteudo').style.marginLeft = '0%';
        }
    </script>
</body>
</html>
