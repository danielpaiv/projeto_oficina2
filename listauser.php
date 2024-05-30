<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit;
}

$user_id = $_SESSION['user_id'];

// Consulta os dados apenas do usuário logado
$sql = "SELECT * FROM clientes WHERE user_id = ? ORDER BY id DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();




include_once('config.php');

// Verifica se o usuário está logado e se é um usuário comum
if (!isset($_SESSION['nome']) || $_SESSION['role'] != 'user') {
    header('Location: index.php');
    exit;
}


//print_r($_SESSION);
if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
//$logado = $_SESSION['nome'];

//$sql = "SELECT * FROM usuarios ORDER BY id DESC";

//$result = $conexao->query($sql);

//print_r($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Listar Serviços</title>

    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <script src="#"></script>
    <script src="#"></script>
</head>
<body>
    <nav>

        <button><a href="formulario.php">Voltar</a></button>
    
        <button><a href="sair.php">Sair</a></button>

    </nav>
    <div class="m-5">
        

        <label for="filtroData"><b>Data de Serviço</b></label>
        <input type="date" id="filtroData" onchange="filtrarPorData()">
        <br>

        <table id="clientesTabela" class="box">
            <thead>
                <tr class="table">
                    <th scope="col">id</th>
                    <!--<th scope="col">user_id</th>>!-->
                    <th scope="col">nome</th>
                    <th scope="col">cnpj</th>
                    <th scope="col">telefone</th>
                    <th scope="col">serviço</th>
                    <th scope="col">data_serv</th>
                    <th scope="col">cidade</th>
                    <th scope="col">estado</th>
                    <th scope="col">endereco</th>
                    <th scope="col">valor</th>
                </tr>
            </thead>
            <tbody class="box">
                <?php
                while ($user_data = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user_data['id'] . "</td>";
                    //echo "<td>".$user_data['user_id']."</td>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['cnpj'] . "</td>";
                    echo "<td>" . $user_data['telefone'] . "</td>";
                    echo "<td>" . $user_data['serviço'] . "</td>";
                    echo "<td>" . $user_data['data_serv'] . "</td>";
                    echo "<td>" . $user_data['cidade'] . "</td>";
                    echo "<td>" . $user_data['estado'] . "</td>";
                    echo "<td>" . $user_data['endereco'] . "</td>";
                    echo "<td>" . $user_data['valor'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function filtrarPorNome() {
            const input = document.getElementById('filtroNome');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[7]; // coluna "Nome"
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

        function filtrarPorData() {
            const input = document.getElementById('filtroData').value;
            const table = document.getElementById('clientesTabela');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[5]; // coluna "Data de Serviço"
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.indexOf(input) > -1) {
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