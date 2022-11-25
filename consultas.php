<?php

session_start();
ob_start();

include_once("conexao.php");

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : "";
$seletor = isset($_GET['seletor']) ? $_GET['seletor'] : "";

$sqlList = "SELECT * FROM todos";
$sqlCount = "SELECT COUNT(1) FROM todos";

if ($seletor && $filtro){
    $sqlList .=  " WHERE {$seletor} like '%$filtro%'";
    $sqlCount .=  " WHERE {$seletor} like '%$filtro%'";
}

// Prepara a QUERY
$result_List = $conexao->prepare($sqlList);
$result_Count = $conexao->prepare($sqlCount);

// Executar a QUERY
$result_List->execute();
$result_Count->execute();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA TODO LIST</title>
    <link rel="stylesheet" href="_css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
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
            <h1>Lista de Trabalho a fazer:</h1>
            <hr><br><br>

            <form method="get" action= "" >
                <div class="form-group">
                    
                    <label class = "pesquisar">Pesquisar:</label><br>
                    <input type="text" name="filtro" class="campo_pesquisar" maxlength="40" requiredrequired autofocus />
                    
                    <select class="campo_select" name="seletor" >
                        <option value="title">Tarefa</option>
                        <option value="date_time">Data de criação</option>
                    </select>

                    <input type="submit" value="Pesquisar" class="bnt_pesquisar">

                    <a href="gerar_pdf.php" class="gerar">
                        <input type="button" value="Gerar PDF" class="bnt">
                        <img src="_img/pdf.png" alt="png" style='width:30px'>
                    </a>
                </div>
            </form>
            <br>

            <?php
            print "<p>Resultado da pesquisa com a palavra: <strong> $filtro </strong> do campo: <strong> $seletor </strong> .<br><br>";

            $result_Count = $conexao->query($sqlCount)->fetchColumn();
            //$conexao->query($sqlCount)->fetchColumn();
            print "<p style='color:red;'>  $result_Count registros encontrados.</p>";
            print "<br>";

            while ($row_dados = $result_List->fetch()) {

                extract($row_dados);

                //echo "ID: $codigo <br>";
                print "<article>";
                print "Codigo: $id<br>";
                print "Tarefa: $title<br>";
                print "Criado em: $date_time<br>";
                
                print "<a href='editar.php?id=" . $row_dados['id'] . "'>Atualizar </a>";
                print "<a href='delete.php?id=" . $row_dados['id'] . "'>Apagar</a>";
                print "</article>";
            }

            ?>
            
        </section>
    </div>

</body>

</html>