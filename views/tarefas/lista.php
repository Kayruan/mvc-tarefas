<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Agenda de Tarefas Pessoais</title>
    <style>
        .card-tarefa { transition: 0.3s; border-left: 5px solid #ccc; min-height: 240px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; }
        .card-tarefa:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
        .prioridade-Alta { border-left-color: #dc3545; }
        .prioridade-Média { border-left-color: #ffc107; }
        .prioridade-Baixa { border-left-color: #198754; }
    </style>
</head>
<body class="bg-light">
<div class="d-flex">
    <div class="bg-dark text-white p-3" style="width: 260px; min-height: 100vh; position: fixed;">
        <h4 class="mb-4 text-center"><i class="bi bi-calendar-check-fill text-primary"></i> Agenda Pessoal</h4>
        <hr>
        <nav class="nav flex-column gap-2">
            <a class="nav-link text-white bg-secondary rounded px-3 py-2" href="index.php?acao=listar"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a class="nav-link text-white rounded px-3 py-2" href="index.php?acao=criar"><i class="bi bi-plus-circle me-2"></i> Agendar Tarefa</a>
        </nav>
    </div>
    
    <div class="container-fluid p-4" style="margin-left: 260px;">
        <?php if(isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= $_SESSION['mensagem'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>
        
        <div class="row mb-4 justify-content-center g-3">
            <?php 
            $agendadas = count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Agendada'));
            $andamento = count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Em Andamento'));
            $concluidas = count(array_filter($tarefas, fn($t) => $t['status_tarefa'] == 'Concluída'));
            
            $metricas = [
                ['Total', count($tarefas), 'bi-list-task', 'text-secondary', 'bg-white'],
                ['Agendadas', $agendadas, 'bi-calendar-event', 'text-dark', 'bg-warning-subtle'],
                ['Em Andamento', $andamento, 'bi-play-circle', 'text-primary', 'bg-primary-subtle'],
                ['Realizadas', $concluidas, 'bi-check-circle-fill', 'text-success', 'bg-success-subtle']
            ];
            foreach ($metricas as $m): ?>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 text-center p-3 <?= $m[4] ?>">
                        <i class="bi <?= $m[2] ?> <?= $m[3] ?> fs-3"></i>
                        <h6 class="text-muted mt-2 mb-1 small"><?= $m[0] ?></h6>
                        <h3 class="fw-bold mb-0"><?= $m[1] ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold"><i class="bi bi-clock-history me-2"></i> Fluxo de Backlog e Estimativas</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center table-striped small">
                        <thead class="table-dark">
                            <tr>
                                <th>Tarefa</th>
                                <th>Data Agendada</th>
                                <th>Horário</th>
                                <th>Duração Estimada</th>
                                <th>Status Atual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($tarefas)): ?>
                                <tr><td colspan="5" class="text-muted p-3">Nenhuma tarefa no backlog.</td></tr>
                            <?php else: ?>
                                <?php foreach($tarefas as $t): ?>
                                <tr>
                                    <td class="fw-bold text-start ps-3"><?= htmlspecialchars($t['titulo']) ?></td>
                                    <td><?= $t['data_tarefa'] ? date('d/m/Y', strtotime($t['data_tarefa'])) : '--/--/----' ?></td>
                                    <td><?= $t['hora_tarefa'] ? date('H:i', strtotime($t['hora_tarefa'])) : '--:--' ?></td>
                                    <td><span class="badge bg-light text-dark border"><?= (int)$t['duracao'] ?> h</span></td>
                                    <td>
                                        <span class="badge <?= $t['status_tarefa'] == 'Concluída' ? 'bg-success' : ($t['status_tarefa'] == 'Em Andamento' ? 'bg-primary' : 'bg-secondary') ?>">
                                            <?= $t['status_tarefa'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-grid-3x3-gap-fill me-2"></i> Quadro de Horários Reservados</h5>
            <input type="text" id="filtro" class="form-control w-25 shadow-sm" placeholder="🔍 Buscar na grade...">
        </div>
        
        <div class="row" id="lista-tarefas">
            <?php foreach ($tarefas as $t): ?>
            <div class="col-md-4 card-tarefa-wrapper mb-4">
                
                <div class="card card-tarefa shadow-sm prioridade-<?= $t['prioridade'] ?>" 
                     style="<?= !empty($t['imagem']) ? "background: url('uploads/{$t['imagem']}'); background-size: cover; background-position: center;" : "" ?>">
                    
                    <div class="card-body <?= !empty($t['imagem']) ? 'bg-white bg-opacity-75' : '' ?> h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold text-dark mb-0"><?= htmlspecialchars($t['titulo']) ?></h5>
                            <span class="badge <?= $t['status_tarefa'] == 'Concluída' ? 'bg-success' : ($t['status_tarefa'] == 'Em Andamento' ? 'bg-primary' : 'bg-secondary') ?>">
                                <?= $t['status_tarefa'] ?>
                            </span>
                        </div>
                        
                        <p class="card-text text-dark fw-medium small mb-3 text-truncate" style="max-height: 40px;"><?= htmlspecialchars($t['descricao'] ?? '') ?></p>
                        
                        <div class="bg-white bg-opacity-75 p-2 rounded border border-light mb-2 small text-dark shadow-xs mt-auto">
                            <div><i class="bi bi-calendar3 me-2 text-primary"></i><b>Dia:</b> <?= $t['data_tarefa'] ? date('d/m/Y', strtotime($t['data_tarefa'])) : 'Não definido' ?></div>
                            <div><i class="bi bi-alarm me-2 text-primary"></i><b>Hora:</b> <?= $t['hora_tarefa'] ? date('H:i', strtotime($t['hora_tarefa'])) : 'Não definido' ?></div>
                            <div><i class="bi bi-hourglass-split me-2 text-primary"></i><b>Duração:</b> <?= (int)$t['duracao'] ?> hora(s)</div>
                        </div>
                        
                        <span class="badge bg-dark bg-opacity-75 mb-2 w-50">Prioridade: <?= $t['prioridade'] ?></span>
                    </div>
                    
                    <div class="card-footer <?= !empty($t['imagem']) ? 'bg-white bg-opacity-75' : 'bg-transparent' ?> border-0 d-flex justify-content-between align-items-center pt-2 pb-3">
                        <div class="btn-group btn-group-sm shadow-xs">
                            <a href="index.php?acao=alterarStatus&status=Agendada&id=<?= $t['id'] ?>" class="btn btn-outline-secondary bg-white" title="Agendar"><i class="bi bi-calendar"></i></a>
                            <a href="index.php?acao=alterarStatus&status=Em%20Andamento&id=<?= $t['id'] ?>" class="btn btn-outline-primary bg-white" title="Iniciar"><i class="bi bi-play-fill"></i></a>
                            <a href="index.php?acao=alterarStatus&status=Concluída&id=<?= $t['id'] ?>" class="btn btn-outline-success bg-white" title="Concluir"><i class="bi bi-check-lg"></i></a>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="index.php?acao=editar&id=<?= $t['id'] ?>" class="btn btn-sm btn-light border text-primary shadow-sm" title="Editar Estrutura"><i class="bi bi-pencil-square"></i></a>
                            <a href="index.php?acao=excluir&id=<?= $t['id'] ?>" class="btn btn-sm btn-light border text-danger btn-excluir shadow-sm" title="Excluir"><i class="bi bi-trash"></i></a>
                        </div>
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