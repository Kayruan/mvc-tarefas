<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Gerenciador de Tarefas</title>
</head>
<body class="container mt-5">
    <h2>Minhas Tarefas</h2>
    <a href="index.php?acao=criar" class="btn btn-primary mb-3">Nova Tarefa</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tarefas as $t): ?>
            <tr>
                <td><?= $t['titulo'] ?></td>
                <td><?= $t['prioridade'] ?></td>
                <td><?= $t['status_tarefa'] ?></td>
                <td>
                    <a href="index.php?acao=editar&id=<?= $t['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="index.php?acao=concluir&id=<?= $t['id'] ?>" class="btn btn-success btn-sm">Concluir</a>
                    <a href="index.php?acao=excluir&id=<?= $t['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   <script src="assets/js/main.js"></script> 
</body>
</html>