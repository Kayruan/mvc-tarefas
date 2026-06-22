<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Agenda de Tarefas Pessoais</title>
    <style>
        .card-tarefa { transition: 0.3s; border-left: 5px solid #ccc; }
        .card-tarefa:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .prioridade-Alta { border-left-color: #dc3545; }
        .prioridade-Média { border-left-color: #ffc107; }
        .prioridade-Baixa { border-left-color: #198754; }
    </style>
</head>
<body class="bg-light">
<div class="d-flex">
    <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
        <h4 class="mb-4 text-center"><i class="bi bi-calendar-check"></i> Agenda Pessoal</h4>
        <nav class="nav flex-column">
            <a class="nav-link text-white" href="index.php?acao=listar"><i class="bi bi-house me-2"></i> Dashboard</a>
            <a class="nav-link text-white" href="index.php?acao=criar"><i class="bi bi-plus-circle me-2"></i> Nova Tarefa</a>
        </nav>
    </div>
    <div class="container-fluid p-4">
        <?php if(isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-success alert-dismissible fade show"><?= $_SESSION['mensagem'] ?></div>
            <?php unset($_SESSION['mensagem']); endif; ?>
        
        <div class="row mb-4">
            <div class="col-md-4"><div class="card bg-primary text-white p-3"><h6>Total</h6><h3><?= count($tarefas) ?></h3></div></div>
            <div class="col-md-4"><div class="card bg-success text-white p-3"><h6>Concluídas</h6><h3><?= count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Concluída')) ?></h3></div></div>
            <div class="col-md-4"><div class="card bg-warning p-3"><h6>Pendentes</h6><h3><?= count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Pendente')) ?></h3></div></div>
        </div>

        <input type="text" id="filtro" class="form-control mb-4" placeholder="🔍 Buscar tarefa...">
        <div class="row" id="lista-tarefas">
            <?php foreach ($tarefas as $t): ?>
            <div class="col-md-4 card-tarefa-wrapper mb-3">
                <div class="card card-tarefa shadow-sm prioridade-<?= $t['prioridade'] ?>">
                    <?php if (!empty($t['imagem'])): ?><img src="uploads/<?= $t['imagem'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;"><?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($t['titulo']) ?></h5>
                        <p class="card-text small text-muted"><?= htmlspecialchars($t['descricao'] ?? '') ?></p>
                        <span class="badge bg-secondary"><?= $t['prioridade'] ?></span>
                        <span class="badge <?= $t['status_tarefa'] == 'Concluída' ? 'bg-success' : 'bg-warning' ?>"><?= $t['status_tarefa'] ?></span>
                    </div>
                    <div class="card-footer bg-white border-0 text-end">
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
<script src="assets/js/main.js"></script>
</body>
</html>