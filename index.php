<?php
session_start();

require_once 'controllers/TarefaController.php';

$controlador = new TarefaController();
$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {
    case 'listar':    $controlador->listar(); break;
    case 'criar':     $controlador->criar(); break;
    case 'salvar':    $controlador->salvar(); break;
    case 'editar':    $controlador->editar(); break;
    case 'atualizar': $controlador->atualizar(); break;
    case 'concluir':  $controlador->concluir(); break;
    case 'excluir':   $controlador->excluir(); break;
    case 'alterarStatus': $controlador->alterarStatus(); break;
    default:          $controlador->listar(); break;
}