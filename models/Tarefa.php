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
        $sql = "SELECT * FROM tarefas ORDER BY FIELD(status_tarefa, 'Pendente', 'Concluída'), data_limite ASC";
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
        // ADICIONADO: 'imagem' no SQL e no array de execução
        $sql = "INSERT INTO tarefas (titulo, descricao, prioridade, data_limite, imagem) 
                VALUES (:titulo, :descricao, :prioridade, :data_limite, :imagem)";

        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':titulo'      => $dados['titulo'],
            ':descricao'   => $dados['descricao'],
            ':prioridade'  => $dados['prioridade'],
            ':data_limite' => $dados['data_limite'],
            ':imagem'      => $dados['imagem'] ?? null 
        ]);
    }

    public function atualizar($dados)
    {
        // ADICIONADO: imagem = :imagem no SET e no array de execução
        $sql = "UPDATE tarefas SET 
                titulo = :titulo, descricao = :descricao, 
                prioridade = :prioridade, status_tarefa = :status_tarefa, 
                data_limite = :data_limite, imagem = :imagem
                WHERE id = :id";

        $comando = $this->conexao->prepare($sql);
        return $comando->execute([
            ':id'            => $dados['id'],
            ':titulo'        => $dados['titulo'],
            ':descricao'     => $dados['descricao'],
            ':prioridade'    => $dados['prioridade'],
            ':status_tarefa' => $dados['status_tarefa'],
            ':data_limite'   => $dados['data_limite'],
            ':imagem'        => $dados['imagem']
        ]);
    }

    public function concluir($id)
    {
        $sql = "UPDATE tarefas SET status_tarefa = 'Concluída' WHERE id = :id";
        $comando = $this->conexao->prepare($sql);
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