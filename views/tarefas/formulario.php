<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>.form-container { max-width: 600px; margin: 50px auto; background: white; padding: 40px; border-radius: 15px; }</style>
</head>
<body class="bg-light">
    <div class="container form-container shadow">
        <h3 class="mb-4 text-center"><?= isset($tarefa) ? 'Editar' : 'Nova' ?> Tarefa</h3>
        <form action="index.php?acao=<?= isset($tarefa) ? 'atualizar' : 'salvar' ?>" method="POST" enctype="multipart/form-data">
            <?php if(isset($tarefa)): ?><input type="hidden" name="id" value="<?= $tarefa['id'] ?>"><?php endif; ?>
            <div class="form-floating mb-3"><input type="text" name="titulo" class="form-control" value="<?= $tarefa['titulo'] ?? '' ?>" required><label>Título</label></div>
            <div class="form-floating mb-3"><textarea name="descricao" class="form-control" style="height: 100px;"><?= $tarefa['descricao'] ?? '' ?></textarea><label>Descrição</label></div>
            <div class="mb-3"><label>Prioridade:</label><select name="prioridade" class="form-select"><option value="Baixa">🟢 Baixa</option><option value="Média">🟡 Média</option><option value="Alta">🔴 Alta</option></select></div>
            <div class="mb-3"><label>Foto:</label><input type="file" name="imagem" class="form-control" accept="image/*"></div>
            <button type="submit" class="btn btn-primary w-100">Salvar Tarefa</button>
            <a href="index.php?acao=listar" class="btn btn-link w-100">Cancelar</a>
        </form>
    </div>
</body>
</html>