// Alerta de confirmação antes de excluir
document.querySelectorAll('.btn-danger').forEach(btn => {
    btn.addEventListener('click', (e) => {
        if (!confirm('Tem certeza que deseja excluir esta tarefa?')) {
            e.preventDefault();
        }
    });
});