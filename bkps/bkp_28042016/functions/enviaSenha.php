<?php
$quebra_linha = "\n";
$emailsender = "erico@instaclick.cl";
$nomeremetente = "Locaweb";
$emaildestinatarios = "erico@instaclick.com";
$comcopia = "erico@instaclick.cl";
$comcopiaoculta = "erico@instaclick.cl";
$assunto = "Teste de ppk - 210116 11:10";
$mensagem = "conteudo";

$mensagemHtml = "<p> Teste da funcao php mail (): </p>
<p>Titulo</p>
<p><b><i>'.$mensagem.'</i></b></p>
<hr>";

$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
$headers .= "From. ".$emailsender.$quebra_linha;
$headers .= "Return-Path: ".$emailsender.$quebra_linha;
$headers .= "Cc: ".$comcopia.$quebra_linha;
$headers .= "Bcc: ".$comcopiaoculta.$quebra_linha;
$headers .= "Reply -To: ".$emailsender.$quebra_linha;

mail($emaildestinatarios, $assunto, $mensagemHtml, $headers, "-r". $emailsender);

echo "1";

?>
