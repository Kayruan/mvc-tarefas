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
        require_once 'views/tarefas/lista.php';
    }

    public function criar()
    {
        require_once 'views/tarefas/formulario.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dados = [
                'titulo'      => $_POST['titulo'],
                'descricao'   => $_POST['descricao'],
                'prioridade'  => $_POST['prioridade'],
                'data_limite' => date('Y-m-d') // Adicionado para evitar erro caso o banco exija
            ];
            
            $this->modelo->cadastrar($dados);
            
            $_SESSION['mensagem'] = "Tarefa criada com sucesso!";
            header('Location: index.php?acao=listar');
            exit;
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
                'data_limite'   => date('Y-m-d')
            ];
            
            $this->modelo->atualizar($dados);
            
            $_SESSION['mensagem'] = "Tarefa atualizada com sucesso!";
            header('Location: index.php?acao=listar');
            exit;
        }
    }

    public function concluir()
    {
        if (isset($_GET['id'])) {
            $this->modelo->concluir($_GET['id']);
            $_SESSION['mensagem'] = "Tarefa marcada como concluída!";
            header('Location: index.php?acao=listar');
            exit;
        }
    }

    public function excluir()
    {
        if (isset($_GET['id'])) {
            $this->modelo->excluir($_GET['id']);
            $_SESSION['mensagem'] = "Tarefa removida do sistema.";
            header('Location: index.php?acao=listar');
            exit;
        }
    }
}