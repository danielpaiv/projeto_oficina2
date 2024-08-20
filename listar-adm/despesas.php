<?php
include_once('conexao.php');

// Consulta para obter os tipos de despesas
$sql = "SELECT id, tipo FROM tipos_despesas";
$result = $conexao->query($sql);
$tipos_despesas = [];
while ($row = $result->fetch_assoc()) {
    $tipos_despesas[] = $row;

    
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Despesa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #313b73ff;
            margin: 20px;
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

        div{
            display: inline-block;
            background-color: #060642 ;
            padding: 5px;
            
            width: 100%;
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

        /*original*/
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }

        h2{
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
        <a href="relatorio-geral.php">Voltar</a>
        <!--<a href="#">Sobre</a>
        <a href="#">Contato</a>
        <a href="#">Mais opções</a>-->
    </nav>

    <main id="conteudo">

            <div>

                <section>
                    <center><h2>Cadastro de Despesa</h2></center>

                    <form method="post" action="processar_despesa.php">
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" required>

                        <label for="valor">Valor:</label>
                        <input type="number" step="0.01" id="valor" name="valor" required>

                        <label for="data">Data:</label>
                        <input type="date" id="data" name="data_insercao" required>

                        <label for="tipo_despesa">Tipo de Despesa:</label>
                        <select id="tipo_despesa" name="tipo_despesa" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($tipos_despesas as $tipo) {
                                echo "<option value='{$tipo['id']}'>{$tipo['tipo']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit">Cadastrar</button>
                    </form>
       
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



