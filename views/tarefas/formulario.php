<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Configurar Agendamento | TaskMaster</title>
    <style>
        body { background-color: #f4f6f9; }
        .form-container { max-width: 650px; margin: 40px auto; background: white; padding: 35px; border-radius: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container shadow-sm border">
            <h3 class="mb-4 text-center text-dark fw-bold">
                <i class="bi bi-calendar-plus text-primary me-2"></i>
                <?= isset($tarefa) ? 'Editar Agendamento' : 'Novo Agendamento de Tarefa' ?>
            </h3>
            
            <form action="index.php?acao=<?= isset($tarefa) ? 'atualizar' : 'salvar' ?>" method="POST" enctype="multipart/form-data">
                <?php if(isset($tarefa)): ?>
                    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                <?php endif; ?>
                
                <div class="form-floating mb-3">
                    <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Título" value="<?= $tarefa['titulo'] ?? '' ?>" required>
                    <label for="titulo">Título da Tarefa / Reserva</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea name="descricao" class="form-control" id="descricao" placeholder="Descrição" style="height: 90px;"><?= $tarefa['descricao'] ?? '' ?></textarea>
                    <label for="descricao">Detalhes do que será executado</label>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">📅 Data Marcada</label>
                        <input type="date" name="data_tarefa" class="form-control" value="<?= $tarefa['data_tarefa'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">⏰ Horário de Início</label>
                        <input type="time" name="hora_tarefa" class="form-control" value="<?= $tarefa['hora_tarefa'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">⏳ Duração (em horas)</label>
                        <input type="number" name="duracao" class="form-control" min="1" placeholder="Ex: 2" value="<?= $tarefa['duracao'] ?? '1' ?>" required>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold"><i class="bi bi-flag"></i> Nível de Prioridade</label>
                        <select name="prioridade" class="form-select">
                            <option value="Baixa" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Baixa') ? 'selected' : '' ?>>🟢 Baixa</option>
                            <option value="Média" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Média') ? 'selected' : '' ?>>🟡 Média</option>
                            <option value="Alta" <?= (isset($tarefa) && $tarefa['prioridade'] == 'Alta') ? 'selected' : '' ?>>🔴 Alta</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold"><i class="bi bi-toggle-on"></i> Estado da Tarefa</label>
                        <select name="status_tarefa" class="form-select">
                            <option value="Agendada" <?= (isset($tarefa) && $tarefa['status_tarefa'] == 'Agendada') ? 'selected' : '' ?>>⚪ Agendada</option>
                            <option value="Em Andamento" <?= (isset($tarefa) && $tarefa['status_tarefa'] == 'Em Andamento') ? 'selected' : '' ?>>🔵 Em Andamento</option>
                            <option value="Concluída" <?= (isset($tarefa) && $tarefa['status_tarefa'] == 'Concluída') ? 'selected' : '' ?>>🟢 Concluída</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold"><i class="bi bi-image"></i> Imagem Ilustrativa / Capa do Card</label>
                    <input type="file" name="imagem" class="form-control" accept="image/*">
                    <?php if(!empty($tarefa['imagem'])): ?>
                        <div class="form-text text-success">Já existe uma imagem salva para esta tarefa. Para mudar, envie uma nova.</div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1 py-2 fw-bold"><i class="bi bi-check-circle"></i> Confirmar Agendamento</button>
                    <a href="index.php?acao=listar" class="btn btn-outline-secondary px-4"><i class="bi bi-x-circle"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>