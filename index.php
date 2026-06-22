<?php
session_start();

// Estrutura base do roteador (os arquivos de controller serão criados nos próximos commits)
$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {
    case 'listar':
    case 'criar':
    case 'salvar':
    case 'editar':
    case 'atualizar':
    case 'concluir':
    case 'excluir':
        // As ações serão conectadas ao Controller no Commit 3
        echo "Sistema de Tarefas - Rota de " . htmlspecialchars($acao) . " estruturada.";
        break;
    default:
        echo "Sistema de Tarefas Inicializado.";
        break;
}