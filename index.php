<?php
session_start();
ob_start();
include_once './conexao.php';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA TODO LIST</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="_css/style.css" type="text/css" />

</head>

<body>
    <div class="container">
        <nav>
            <ul class="menu">
                <a href="index.php">
                    <li>Cadastro</li>
                </a>
                <a href="consultas.php">
                    <li>Consultas Tarefas</li>
                </a>

            </ul>
        </nav>

        <section>
            <h1 class="title">Lista de Tarefas Diarias</h1>
            <hr><br>
            <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>

            <form name="adicianar" action="processa.php" method="post">

                <div class="form-group">
                    <label>Nova Tarefa <br> </label>
                    <input type="text" placeholder="O que você precisa fazer?" name="title" class="campo" required autofocus /><br>
                </div>

                <input type="submit" value="Adicionar" class="bnt" name="adicianar">
                <input type="reset" value="Limpar" class="bnt">
            </form>

        </section>

    </div>

</body>

</html>