<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3209/3209260.png">
    <title>TaskMaster Pro</title>
    <style>
        .card-tarefa { transition: 0.3s; border-left: 5px solid #ccc; }
        .card-tarefa:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .prioridade-Alta { border-left-color: #dc3545; }
        .prioridade-Média { border-left-color: #ffc107; }
        .prioridade-Baixa { border-left-color: #198754; }
        #wrapper { display: flex; }
    </style>
</head>
<body class="bg-light">

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
        <h4 class="mb-4 text-center"><i class="bi bi-kanban"></i> TaskMaster</h4>
        <hr>
        <nav class="nav flex-column">
            <a class="nav-link text-white" href="index.php?acao=listar"><i class="bi bi-house me-2"></i> Dashboard</a>
            <a class="nav-link text-white" href="index.php?acao=criar"><i class="bi bi-plus-circle me-2"></i> Nova Tarefa</a>
        </nav>
    </div>
    
    <!-- Conteúdo Principal -->
    <div class="container-fluid p-4">
        
        <!-- Mensagem de Feedback -->
        <?php if(isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i> <?= $_SESSION['mensagem'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Minhas Tarefas</h2>
            <input type="text" id="filtro" class="form-control w-25" placeholder="🔍 Buscar tarefa...">
        </div>

        <div class="row" id="lista-tarefas">
            <?php foreach ($tarefas as $t): ?>
            <div class="col-md-4 mb-4 card-tarefa-wrapper">
                <div class="card card-tarefa shadow-sm prioridade-<?= $t['prioridade'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($t['titulo']) ?></h5>
                        <p class="card-text text-muted small"><?= htmlspecialchars($t['descricao'] ?? 'Sem descrição') ?></p>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>