<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Agenda de Tarefas Pessoais</title>
    <style>
        .card-tarefa { transition: 0.3s; border-left: 5px solid #ccc; height: 100%; min-height: 200px; }
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
        
        <div class="row mb-5 justify-content-center">
            <?php 
            $metricas = [
                ['Total', count($tarefas), 'bi-list-task', 'text-primary'],
                ['Concluídas', count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Concluída')), 'bi-check2-circle', 'text-success'],
                ['Pendentes', count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Pendente')), 'bi-clock', 'text-warning']
            ];
            foreach ($metricas as $m): ?>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 text-center p-3">
                        <i class="bi <?= $m[2] ?> <?= $m[3] ?> fs-2"></i>
                        <h6 class="text-muted mt-2"><?= $m[0] ?></h6>
                        <h3 class="fw-bold"><?= $m[1] ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <input type="text" id="filtro" class="form-control mb-4" placeholder="🔍 Buscar tarefa...">
        
        <div class="row" id="lista-tarefas">
            <?php foreach ($tarefas as $t): ?>
            <div class="col-md-4 card-tarefa-wrapper mb-3">
                <div class="card card-tarefa shadow-sm prioridade-<?= $t['prioridade'] ?>" 
                     style="<?= !empty($t['imagem']) ? 'background: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)), url("../../uploads/'.$t['imagem'].'"); background-size: cover; background-position: center;' : '' ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($t['titulo']) ?></h5>
                        <p class="card-text small"><?= htmlspecialchars($t['descricao'] ?? '') ?></p>
                        <span class="badge bg-secondary"><?= $t['prioridade'] ?></span>
                        <span class="badge <?= $t['status_tarefa'] == 'Concluída' ? 'bg-success' : 'bg-warning' ?>">
                            <?= $t['status_tarefa'] ?>
                        </span>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
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