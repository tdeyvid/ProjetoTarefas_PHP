<?php

// Carregar o Composer
require './vendor/autoload.php';

// Incluir conexao com BD
include_once './conexao.php';

// QUERY para recuperar os registros do banco de dados
$sql = "SELECT `id`, `title` , `date_time` FROM todos ";

// Prepara a QUERY
$result_dados = $conexao->prepare($sql);

// Executar a QUERY
$result_dados->execute();

// Informacoes para o PDF
$exibirDados = "<!DOCTYPE html>";
$exibirDados .= "<html lang='pt-br'>";
$exibirDados .= "<head>";
$exibirDados .= "<meta charset='UTF-8'>";
$exibirDados .= "<link rel='stylesheet' href='_css/custom.css'";
$exibirDados .= "<link rel='stylesheet' href='http://localhost/projetopdo/_css/relatorio.css'";
$exibirDados .= "<link rel='preconnect' href='https://fonts.googleapis.com' />";
$exibirDados .= "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin />";
$exibirDados .= "<link href='https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' rel='stylesheet' />";

$exibirDados .= "<title>SISTEMA TODO LIST</title>";
$exibirDados .= "</head>";
$exibirDados .= "<body>";
$exibirDados .= "<h1>Relatório completo das Atividades.</h1>";

// Ler os registros retornado do BD

while($row_dados = $result_dados->fetch(PDO::FETCH_ASSOC)){
    //var_dump($row_dados);
    extract($row_dados);
    $exibirDados .= "Codigo: $id<br>";
    $exibirDados .= "Atividade: $title <br>";
    $exibirDados .= "Criado em: $date_time <br>";
 
    $exibirDados .= "<hr>";
}

$exibirDados .= "</body>";
$exibirDados .= "</html>";

// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote' => true]);

// Instanciar o metodo loadHtml e enviar o conteudo do PDF
$dompdf->loadHtml($exibirDados);

// Configurar o tamanho e a orientacao do papel
// landscape - Imprimir no formato paisagem
//$dompdf->setPaper('A4', 'landscape');
// portrait - Imprimir no formato retrato
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream();
