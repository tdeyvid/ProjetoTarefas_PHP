<?php
session_start();
ob_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não encontrado!</p>";
    header("Location: editar.php");
    exit();
}

$sql = "SELECT * FROM todos WHERE id = $id LIMIT 1";
$result_dados = $conexao->prepare($sql);
$result_dados->execute();

if (($result_dados) and ($result_dados->rowCount() != 0)) {
    $row_dados = $result_dados->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_dados);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não encontrado!</p>";
    header("Location: editar.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SISTEMA TODO LIST</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="_css/style.css">
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
            <h1>Editar cadastro de equipamentos - MIS</h1>
            <hr><br>

            <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>

            <?php
            //Receber os dados do formulário
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            //Verificar se o usuário clicou no botão
            if (!empty($dados['EditarDados'])) {
                $empty_input = false;
                $dados = array_map('trim', $dados);
                if (in_array("", $dados)) {
                    $empty_input = true;
                    echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
                } 

                if(!$empty_input) {

                    $sql = "UPDATE todos SET title=:title WHERE id=:id";

                    $edit_dados = $conexao->prepare($sql);
                    $edit_dados->bindParam(':title', $dados['title'], PDO::PARAM_STR);
                    $edit_dados->bindParam(':id', $id);
 
                    $edit_dados->execute();


                    if ($edit_dados->rowCount()) {
                        $_SESSION['msg'] = "<p style='color: green;'>Editado com sucesso!</p>";
                        header("Location: index.php");
                    } else {
                        echo "<p style='color: #f00;'>Erro: Não editado com sucesso!</p>";
                    }
                }
            }
            ?>

            <form id="editar" action="" method="post">

                <div class="form-group">
                    <input type="text" placeholder="Nome do equipamento" id= "title" name="title" class="campo" value="<?php
                    if (isset($dados['title'])) {
                        echo $dados['title'];
                   } elseif (isset($row_dados['title'])) {
                     echo $row_dados['title'];
                  } ?>" /><br>
                </div>

                <input type="submit" value="Atualizar" name="EditarDados" class="bnt">

                <a href="index.php">Voltar(Cadastrar)</a>
            </form>

        </section>

    </div>

</body>

</html>