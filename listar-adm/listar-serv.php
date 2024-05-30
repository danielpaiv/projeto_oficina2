
<?php
    session_start();
//esse codigo é responsável por criptografar a pagina viinculado ao codigo teste login.

        
include_once('config.php');
//print_r($_SESSION);
if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
$logado = $_SESSION['nome'];

$sql = "SELECT * FROM usuarios ORDER BY id DESC";

//$result = $conexao->query($sql);

//print_r($result);


    include_once('conexao.php');
    //print_r($_SESSION);
   

    $sql = "SELECT * FROM clientes ORDER BY id DESC";

    $result = $conexao->query($sql);

    //print_r($result);

        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Serviços</title>

    <link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
    <!--<script src="filtroNome.js"></script>
    <script src="filtroData.js"></script>!-->

</head>

<body>
    <nav>
    <button><a href="sair.php">Sair</a></button>
    </nav>



<div class="m-5">

        <label for="filtroNome">Filtrar por nome:</label>
        <input type="text" id="filtroNome" onkeyup="filtrarPorNome()">

        <label for="filtroData"><b>Data de Serviço</b></label>
        <input type="date" id="filtroData" onchange="filtrarPorData()">
        <br>
    

        <table id="clientesTabela" class="box">
            <thead>
                <tr class="table">
                <th scope="col">id</th>
                    <th scope="col">nome</th>
                    <th scope="col">cnpj</th>
                    <th scope="col">telefone</th>
                    <th scope="col">serviço</th>
                    <th scope="col">data_serv</th>
                    <th scope="col">cidade</th>
                    <th scope="col">estado</th>
                    <th scope="col">endereco</th>
                    <th scope="col">valor</th>
                    
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="box">
                <?php
                    while($user_data = mysqli_fetch_assoc($result))
                    {
                        echo "<tr>";
                        echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['cnpj']."</td>";
                        echo "<td>".$user_data['telefone']."</td>";
                        echo "<td>".$user_data['serviço']."</td>";
                        echo "<td>".$user_data['data_serv']."</td>";
                        echo "<td>".$user_data['cidade']."</td>";
                        echo "<td>".$user_data['estado']."</td>";
                        echo "<td>".$user_data['endereco']."</td>";
                        echo "<td>".$user_data['valor']."</td>";
                                                  
                        echo "</td>";
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

        console.log('Filtro Nome:', filter);
        console.log('Texto da Coluna:', txtValue);

    </script>
</body>
</html>