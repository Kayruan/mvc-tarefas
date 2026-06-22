<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Gerenciar Tarefa</title>
    <style>
        body { background-color: #f8f9fa; }
        .form-container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> <?= isset($tarefa) ? 'Editar Tarefa' : 'Nova Tarefa' ?></h3>
            
            <form action="index.php?acao=<?= isset($tarefa) ? 'atualizar' : 'salvar' ?>" method="POST">
                <?php if(isset($tarefa)): ?> <input type="hidden" name="id" value="<?= $tarefa['id'] ?>"> <?php endif; ?>
                
                <div class="form-floating mb-3">
                    <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Título" value="<?= $tarefa['titulo'] ?? '' ?>" required>
                    <label for="titulo">Título da Tarefa</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea name="descricao" class="form-control" id="descricao" placeholder="Descrição" style="height: 100px;"><?= $tarefa['descricao'] ?? '' ?></textarea>
                    <label for="descricao">Descrição detalhada</label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Prioridade</label>
                        <select name="prioridade" class="form-select">
                            <option value="Baixa" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Baixa') ? 'selected' : '' ?>>🟢 Baixa</option>
                            <option value="Média" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Média') ? 'selected' : '' ?>>🟡 Média</option>
                            <option value="Alta" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Alta') ? 'selected' : '' ?>>🔴 Alta</option>
                        </select>
                    </div>
                    
                    <?php if(isset($tarefa)): ?>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Status</label>
                        <select name="status_tarefa" class="form-select">
                            <option value="Pendente" <?= $tarefa['status_tarefa'] == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                            <option value="Concluída" <?= $tarefa['status_tarefa'] == 'Concluída' ? 'selected' : '' ?>>Concluída</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mt-3"><i class="bi bi-save"></i> Salvar Alterações</button>
                <a href="index.php?acao=listar" class="btn btn-outline-secondary w-100 mt-2">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>