<?php
require_once 'models/Tarefa.php';

class TarefaController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Tarefa();
    }

    public function listar()
    {
        $tarefas = $this->modelo->listarTodas();
        // Vamos criar esta view na próxima etapa
        require_once 'views/tarefas/lista.php';
    }

    public function criar()
    {
        // Vamos criar esta view na próxima etapa
        require_once 'views/tarefas/formulario.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dados = [
                'titulo'      => $_POST['titulo'],
                'descricao'   => $_POST['descricao'],
                'prioridade'  => $_POST['prioridade'],
                'data_limite' => $_POST['data_limite']
            ];
            $this->modelo->cadastrar($dados);
            
            $_SESSION['mensagem'] = "Tarefa criada com sucesso!";
            header('Location: index.php?acao=listar');
        }
    }

    public function editar()
    {
        $id = $_GET['id'];
        $tarefa = $this->modelo->buscarPorId($id);
        require_once 'views/tarefas/formulario.php';
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dados = [
                'id'            => $_POST['id'],
                'titulo'        => $_POST['titulo'],
                'descricao'     => $_POST['descricao'],
                'prioridade'    => $_POST['prioridade'],
                'status_tarefa' => $_POST['status_tarefa'],
                'data_limite'   => $_POST['data_limite']
            ];
            $this->modelo->atualizar($dados);
            
            $_SESSION['mensagem'] = "Tarefa atualizada com sucesso!";
            header('Location: index.php?acao=listar');
        }
    }

    public function concluir()
    {
        $id = $_GET['id'];
        $this->modelo->concluir($id);
        
        $_SESSION['mensagem'] = "Oba! Tarefa concluída!";
        header('Location: index.php?acao=listar');
    }

    public function excluir()
    {
        $id = $_GET['id'];
        $this->modelo->excluir($id);
        
        $_SESSION['mensagem'] = "Tarefa excluída do sistema.";
        header('Location: index.php?acao=listar');
    }
}