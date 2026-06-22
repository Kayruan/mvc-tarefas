<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card-tarefa { transition: 0.3s; border-left: 5px solid #ccc; }
        .card-tarefa:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .prioridade-Alta { border-left-color: #dc3545; }
        .prioridade-Média { border-left-color: #ffc107; }
        .prioridade-Baixa { border-left-color: #198754; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-check2-square"></i> TaskMaster Pro</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2>Minhas Tarefas</h2>
            <a href="index.php?acao=criar" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nova Tarefa</a>
        </div>

        <div class="row">
            <?php foreach ($tarefas as $t): ?>
            <div class="col-md-4 mb-4">
                <div class="card card-tarefa shadow-sm prioridade-<?= $t['prioridade'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($t['titulo']) ?></h5>
                        <p class="card-text text-muted small"><?= $t['descricao'] ?? 'Sem descrição' ?></p>
                        <span class="badge bg-secondary"><?= $t['prioridade'] ?></span>
                        <span class="badge <?= $t['status_tarefa'] == 'Concluída' ? 'bg-success' : 'bg-warning' ?>">
                            <?= $t['status_tarefa'] ?>
                        </span>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2">
                        <a href="index.php?acao=editar&id=<?= $t['id'] ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="index.php?acao=concluir&id=<?= $t['id'] ?>" class="btn btn-outline-success btn-sm"><i class="bi bi-check-lg"></i></a>
                        <a href="index.php?acao=excluir&id=<?= $t['id'] ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>