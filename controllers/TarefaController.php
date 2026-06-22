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
                'data_limite' => date('Y-m-d')
            ];

            // Tratamento de upload de imagem
            if (!empty($_FILES['imagem']['name'])) {
                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $nomeArquivo = time() . '.' . $extensao;
                
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeArquivo)) {
                    $dados['imagem'] = $nomeArquivo;
                }
            } else {
                $dados['imagem'] = null;
            }
            
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

            // Atualização de imagem (se houver nova)
            if (!empty($_FILES['imagem']['name'])) {
                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $nomeArquivo = time() . '.' . $extensao;
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeArquivo);
                $dados['imagem'] = $nomeArquivo;
            } else {
                // Mantém a imagem anterior se não enviar uma nova
                $tarefaAntiga = $this->modelo->buscarPorId($_POST['id']);
                $dados['imagem'] = $tarefaAntiga['imagem'];
            }
            
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
            // Opcional: deletar o arquivo de imagem do servidor ao excluir a tarefa
            $tarefa = $this->modelo->buscarPorId($_GET['id']);
            if (!empty($tarefa['imagem']) && file_exists('uploads/' . $tarefa['imagem'])) {
                unlink('uploads/' . $tarefa['imagem']);
            }

            $this->modelo->excluir($_GET['id']);
            $_SESSION['mensagem'] = "Tarefa removida com sucesso!";
            header('Location: index.php?acao=listar');
            exit;
        }
    }
}