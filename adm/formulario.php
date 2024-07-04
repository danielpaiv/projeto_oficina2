<?php
    //esse codigo é responsável por criptografar a pagina viinculado ao codigo teste login.

    session_start();
    include_once('config.php');
    //print_r($_SESSION);
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    }
    //$logado = $_SESSION['nome'];

    //$sql = "SELECT * FROM usuarios ORDER BY id DESC";

    //$result = $conexao->query($sql);

    //print_r($result);

?>

<?php

    if(isset($_POST['submit']))
    {
        //print_r('Email:' . $_POST['email']);
        //print_r('<br>');
        
        //print_r('Nome:' . $_POST['nome']);
        //print_r('<br>');
    
        //print_r('Sobrenome:' . $_POST['sobrenome']);
        //print_r('<br>');
        
        //print_r('Senha:' . $_POST['senha']);
        //print_r('<br>');
        
    
       
     include_once('config.php');

     
     $email = $_POST['email'];
     $nome = $_POST['nome'];
     $sobrenome = $_POST['sobrenome'];
     $senha = $_POST['senha'];
     $user_id = $_POST['user_id'];
     
   

 
     $result = mysqli_query($conexao, "INSERT INTO  usuarios(email,nome,sobrenome,senha,user_id)
     VALUES ('$email','$nome','$sobrenome','$senha',$user_id)");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela login</title>
    <style>
        body{
            
            background-image: linear-gradient(to right,rgb(88, 89, 20), rgb(186, 170, 0));
            font-family: Arial, Helvetica, sans-serif;
        }
        .box{
            columns: 1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-image: linear-gradient(to right,rgb(133, 135, 33), rgb(255, 238, 48));
            padding: 15px;
            border-radius: 15px;
            width: 30%;
            color: rgb(15, 15, 15);
        }
        .inputbox{
            position: relative;
           
        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid rgb(11, 11, 11);
            outline: none;
            color: rgb(8, 8, 8);
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
            color: rgb(3, 3, 3);
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 12px;
            color: dodgerblue;
        }
        .button{
            background-color: rgb(253, 253, 154);
            padding: 15px;
            border-radius: 15px;
            position: absolute;
           
            
            
        }
        #submit
        {
            background-image: linear-gradient(to right,rgb(233, 235, 86), rgb(255, 238, 48));
            width: 100%;
            border: none;
            padding: 10px;
            color: black;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }
        #submit:hover
        {
            background-image: linear-gradient(to right,rgb(255, 238, 48), rgb(233, 235, 86));
        }
        .btn{
            text-decoration: none;
            color:red ;
            padding: 5px;
        }
        nav{
            background-color: red;
            padding: 7px;
            position: absolute;
        }
       
       

    </style>
</head>
        
        <nav>
            <button><a href="sair.php" class="btn btn-danger me-10">Sair</a></button>
            </div>
        </nav>

        <br><br>
<body>
    <h1>Olá Adm !</h1>
    <br><br><br><br><br>
    <h2>Sistema de registro de fucionário.</h2>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
   <!-- <div class="button">
        <a href="#">Acesse o sistema aqui</a>
        
    </div>>-->
   
    
        <div class="box">
            <h3>Cadastre-se</h3>
            <form action="formulario.php" method="POST">
                <legend><b>Preencha seus dados</b></legend>
                <br>
                <br>
                <br>

                <div class="inputbox">
                    <input type="text" name="user_id" id="user_id" class="inputUser" required>
                    <label for="user_id" class="labelInput">user_id</label>
                </div>
                <br><br>

                <div class="inputbox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">email</label>
                </div>
                <br>
                <br>
                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">nome</label>
                </div>
                <br>
                <br>
                <div class="inputbox">
                    <input type="text" name="sobrenome" id="sobrenome" class="inputUser" required>
                    <label for="sobrenome" class="labelInput">sobrenome</label>
                </div>
                <br>
                <br>
                <div class="inputbox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">senha</label>
                </div>
                <br>
                <br>
                <input type="submit" name="submit" id="submit">
            </form>
        </div>
  
</body>
</html>