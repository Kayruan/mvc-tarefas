<?php
require_once 'config/database.php';

class Tarefa
{
    private $conexao;

    public function __construct()
    {
        $bancoDeDados = new Database();
        $this->conexao = $bancoDeDados->connect();
    }

    public function listarTodas()
    {
        // Ordena por status prioritários e depois por data/hora do agendamento
        $sql = "SELECT * FROM tarefas ORDER BY FIELD(status_tarefa, 'Em Andamento', 'Agendada', 'Concluída'), data_tarefa ASC, hora_tarefa ASC";
        $comando = $this->conexao->query($sql);
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':id', $id, PDO::PARAM_INT);
        $comando->execute();
        return $comando->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dados)
    {
        $sql = "INSERT INTO tarefas (titulo, descricao, prioridade, status_tarefa, data_tarefa, hora_tarefa, duracao, imagem) 
                VALUES (:titulo, :descricao, :prioridade, :status_tarefa, :data_tarefa, :hora_tarefa, :duracao, :imagem)";

        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':titulo'        => $dados['titulo'],
            ':descricao'     => $dados['descricao'],
            ':prioridade'    => $dados['prioridade'],
            ':status_tarefa' => $dados['status_tarefa'] ?? 'Agendada',
            ':data_tarefa'   => !empty($dados['data_tarefa']) ? $dados['data_tarefa'] : null,
            ':hora_tarefa'   => !empty($dados['hora_tarefa']) ? $dados['hora_tarefa'] : null,
            ':duracao'       => !empty($dados['duracao']) ? $dados['duracao'] : 0,
            ':imagem'        => $dados['imagem'] ?? null
        ]);
    }

    public function atualizar($dados)
    {
        $sql = "UPDATE tarefas SET 
                titulo = :titulo, descricao = :descricao, prioridade = :prioridade, 
                status_tarefa = :status_tarefa, data_tarefa = :data_tarefa, 
                hora_tarefa = :hora_tarefa, duracao = :duracao, imagem = :imagem
                WHERE id = :id";

        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':id'            => $dados['id'],
            ':titulo'        => $dados['titulo'],
            ':descricao'     => $dados['descricao'],
            ':prioridade'    => $dados['prioridade'],
            ':status_tarefa' => $dados['status_tarefa'],
            ':data_tarefa'   => !empty($dados['data_tarefa']) ? $dados['data_tarefa'] : null,
            ':hora_tarefa'   => !empty($dados['hora_tarefa']) ? $dados['hora_tarefa'] : null,
            ':duracao'       => !empty($dados['duracao']) ? $dados['duracao'] : 0,
            ':imagem'        => $dados['imagem']
        ]);
    }

    public function alterarStatus($id, $status)
    {
        $sql = "UPDATE tarefas SET status_tarefa = :status WHERE id = :id";
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':status', $status, PDO::PARAM_STR);
        $comando->bindValue(':id', $id, PDO::PARAM_INT);
        return $comando->execute();
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM tarefas WHERE id = :id";
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':id', $id, PDO::PARAM_INT);
        return $comando->execute();
    }
}