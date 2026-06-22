<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tarefa</title>
</head>
<body class="container mt-5">
    <h2><?= isset($tarefa) ? 'Editar Tarefa' : 'Nova Tarefa' ?></h2>
    <form action="index.php?acao=<?= isset($tarefa) ? 'atualizar' : 'salvar' ?>" method="POST">
        <?php if(isset($tarefa)): ?> <input type="hidden" name="id" value="<?= $tarefa['id'] ?>"> <?php endif; ?>
        
        <div class="mb-3">
            <label>Título:</label>
            <input type="text" name="titulo" class="form-control" value="<?= $tarefa['titulo'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Prioridade:</label>
            <select name="prioridade" class="form-control">
                <option value="Baixa" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Baixa') ? 'selected' : '' ?>>Baixa</option>
                <option value="Média" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Média') ? 'selected' : '' ?>>Média</option>
                <option value="Alta" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</body>
</html>