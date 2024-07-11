<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit;
}

//print_r($_SESSION);
if((!isset($_SESSION['nome']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
 $logado = $_SESSION['nome'];

//$sql = "SELECT * FROM usuarios ORDER BY id DESC";

//$result = $conexao->query($sql);

//print_r($result);


if (isset($_POST['submit'])) {
    include_once('conexao.php');

    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    $telefone = $_POST['telefone'];
    $servico = $_POST['servico'];
    $data_serv = $_POST['data_serv'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $endereco = $_POST['endereco'];
    $valor = $_POST['valor'];
    $user_id = $_POST['user_id']; // Obtém o ID do usuário da sessão
    $forma_pagamento = $_POST['forma_pagamento'];
    $estoque = $_POST['estoque'];

    // Insere os dados no banco de dados, incluindo o ID do usuário
    $stmt = $conexao->prepare("INSERT INTO clientes (user_id, nome, cnpj, telefone, servico, data_serv, cidade, estado, endereco, forma_pagamento, valor, estoque) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssi", $user_id, $nome, $cnpj, $telefone, $servico, $data_serv, $cidade, $estado, $endereco, $forma_pagamento, $valor, $estoque);
    $stmt->execute();

    //header('Location: listaadm.php'); // Redireciona para a página de listagem após o cadastro
    header('Location: http://localhost/projeto_oficina/listar-adm/listar-serv.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario | SERVIÇO</title>
    <style>
        
        /* Seu CSS aqui */
        body{
        font-family: Arial, Helvetica, sans-serif;
        /*background-image: linear-gradient(to right,rgb(20,147,220), rgb(17,54,71));*/
        background-color:#000066;
        }
        .box{
            columns: 1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 15px;
            width: 30%;
            right: 30%;
            color: white;
        }
        fieldset{
            border: 3px solid dodgerblue; 
        }
        legend{
            border: 1px solid dodgerblue; 
            padding: 10px;
            text-align: center;
            background-color: dodgerblue;
            border-radius: 5px;
            
        }
        .inputbox{
            position: relative;

        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 3px;
        }
        .labelInput{
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5px;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 12px;
            color: dodgerblue;
        }
        #data_nacimento{
            border: none;
            padding: 8px;
            border-radius: 10px;
            color: dodgerblue;
            outline: none;
            font-size: 15px;
        }
        #submit{
            background-image: linear-gradient(to right,rgb(130, 20, 220), rgb(44, 31, 220));
            width: 100%;
            border: none;
            padding: 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }
        #submit:hover{
            background-image: linear-gradient(to right,rgb(27, 20, 220), rgb(102, 14, 184));
        }
        .btn{
            color:white ;
            padding: 5px;
            text-decoration: none;
        }
        button{
            border-radius: 5px;
            text-decoration: none;
            border: none;
            padding: 15px;
            background-image: linear-gradient(to right,rgb(130, 20, 220), rgb(44, 31, 220));

        }
        nav{
            border: 5px solid dodgerblue;
            position: absolute;
            letter-spacing: 3px;
        }
        @media screen and (max-width: 400px){
            body{
                background-color:#000066;
            }
        }
        @media screen and (max-width: 400px){
            .box{
                width: 100%;
                top:75%;
            }
        }
        @media screen and (max-width: 400px){
            nav{
                top:0%;
                
            }
        }
        h2{
            color:white;
        }
        #data_serv{
            color:black;
            border:black;
        }
        .box{
            top:55%;
            
        }
    </style>
</head>
<body>
    <nav> 
        <button><a href="sair.php" class="btn btn-danger me-5">Sair</a></button>
        
        <button><a href="https://lightcoral-cassowary-439946.hostingersite.com/listar-adm/listar-serv.php" class="btn btn-danger me-5">Voltar</a></button>
    </nav> 
    <div class="box">
        <form action="formulario_copy.php" method="POST">
            <fieldset>
                <legend><b>Cadastro de Produtos</b></legend>
                <br><br>


                <div class="inputbox">
                    <input type="text" name="user_id" id="user_id" class="inputUser" required>
                    <label for="user_id" class="labelInput">user_id</label>
                </div>
                <br><br>
            <!--
                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser" >
                    <label for="nome" class="labelInput">Cliente</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="text" name="cnpj" id="cnpj" class="inputUser" >
                    <label for="cnpj" class="labelInput">CNPJ</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" >
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                
                <p>Serviço de Limpeza</p>
            -->
                <div class="inputbox">
                    <input type="text" name="servico" id="servico" class="inputUser" required>
                    <label for="servico" class="labelInput">Produto</label>
                </div>
                
            <!--
                <input type="radio" id="fachada" name="serviço" value="limpeza de fachada" required>
                <label for="fachada">Fachada</label>
                <input type="radio" id="vidros" name="serviço" value="limpeza de vidros" required>
                <label for="vidros">Vidros</label>
                <input type="radio" id="outro" name="serviço" value="outro" required>
                <label for="outro">Outro</label>
            -->
                <br><br>
                <label for="data_serv"><b>Data do Serviço</b></label>
                <input type="date" name="data_serv" id="data_serv" required>  
                <br><br>
            <!--
                <div class="inputbox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" >
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="text" name="estado" id="estado" class="inputUser" >
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" >
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <br>
                <p>pagamento</p>
                <input type="radio" id="dinheiro" name="forma_pagamento" value="dinheiro"  >
                <label for="dinheiro">dinheiro</label>

                <input type="radio" id="debito" name="forma_pagamento" value="debito"  >
                <label for="debito">debito</label>
                
                <input type="radio" id="credito" name="forma_pagamento" value="credito"  >
                <label for="credito">credito</label>

                <input type="radio" id="pix" name="forma_pagamento" value="pix" >
                <label for="pix">Pix</label>
                <br><br>
            -->
                <div class="inputbox">
                    <input type="text" name="valor" id="valor" class="inputUser" required>
                    <label for="valor" class="labelInput">Valor</label>
                </div>
                <br><br>
                <div class="inputbox">
                    <input type="text" name="estoque" id="estoque" class="inputUser" required>
                    <label for="estoque" class="labelInput">estoque</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
</body>
</html>