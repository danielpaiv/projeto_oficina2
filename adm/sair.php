<?php
 session_start();
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    header('Location: http://localhost/teste-usuario2/index.php');

?>