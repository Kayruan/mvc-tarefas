<?php
require_once 'models/Tarefa.php';

class TarefaController
{
    private $modelo;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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
                'titulo'        => $_POST['titulo'],
                'descricao'     => $_POST['descricao'],
                'prioridade'    => $_POST['prioridade'],
                'status_tarefa' => $_POST['status_tarefa'] ?? 'Agendada',
                'data_tarefa'   => $_POST['data_tarefa'],
                'hora_tarefa'   => $_POST['hora_tarefa'],
                'duracao'       => $_POST['duracao']
            ];

            if (!empty($_FILES['imagem']['name'])) {
                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $nomeArquivo = time() . '.' . $extensao;
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeArquivo)) {
                    $dados['imagem'] = $nomeArquivo;
                }
            }

            $this->modelo->cadastrar($dados);
            $_SESSION['mensagem'] = "Tarefa agendada com sucesso!";
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
                'data_tarefa'   => $_POST['data_tarefa'],
                'hora_tarefa'   => $_POST['hora_tarefa'],
                'duracao'       => $_POST['duracao']
            ];

            if (!empty($_FILES['imagem']['name'])) {
                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $nomeArquivo = time() . '.' . $extensao;
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeArquivo);
                $dados['imagem'] = $nomeArquivo;
            } else {
                $tarefaAntiga = $this->modelo->buscarPorId($_POST['id']);
                $dados['imagem'] = $tarefaAntiga['imagem'];
            }

            $this->modelo->atualizar($dados);
            $_SESSION['mensagem'] = "Tarefa atualizada com sucesso!";
            header('Location: index.php?acao=listar');
            exit;
        }
    }

    public function alterarStatus()
    {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $this->modelo->alterarStatus($_GET['id'], $_GET['status']);
            $_SESSION['mensagem'] = "Status da tarefa alterado para: " . $_GET['status'];
            header('Location: index.php?acao=listar');
            exit;
        }
    }

    public function excluir()
    {
        if (isset($_GET['id'])) {
            $tarefa = $this->modelo->buscarPorId($_GET['id']);
            if (!empty($tarefa['imagem']) && file_exists('uploads/' . $tarefa['imagem'])) {
                unlink('uploads/' . $tarefa['imagem']);
            }
            $this->modelo->excluir($_GET['id']);
            $_SESSION['mensagem'] = "Tarefa removida da agenda.";
            header('Location: index.php?acao=listar');
            exit;
        }
    }
}