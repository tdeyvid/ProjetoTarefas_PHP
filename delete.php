<?php
session_start();

include_once("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

	$sql = "DELETE FROM `todos` WHERE id='$id'";

	// Prepara a QUERY
	$result_dados = $conexao->prepare($sql);

	// Executar a QUERY
	$apagar_dados = $conexao->prepare($sql);

		if ($apagar_dados->execute()) {
			$_SESSION['msg'] = "<p style='color: green;'>Tarefa apagado com sucesso!</p>";
			header("Location: index.php");
		} else {
			$_SESSION['msg'] = "<p style='color: #f00;'>Tarefa não apagado com sucesso!</p>";
			header("Location: index.php");
		}
	
}else {
	$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Tarefa não encontrado!</p>";
	header("Location: index.php");
}